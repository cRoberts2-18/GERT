from flask import Flask, render_template, request, redirect, url_for, session
import cdsapi
import pygrib
import mysql.connector

app= Flask(__name__)
app.secret_key="GERTool31"

@app.route('/')
def home():
    if session.get('LoggedIn')==True:
        return render_template('home.html')
    else:
        return redirect(url_for("loginPage"))

@app.route('/profile/')
def profile():
    if session.get('LoggedIn')==True:
        return render_template('profile.html')
    else:
        return redirect(url_for("loginPage"))

@app.route('/signup/')
def signup():
    return render_template('GertSignUp.html')

@app.route('/resetPassword/')
def resetPassword():
    return render_template('GertResetPassword.html')

@app.route('/login/', methods = ['GET', 'POST'])
def loginPage():
    return render_template('login.html')

@app.route('/saved/', methods = ['GET','POST'])
def saved():
    if session.get('LoggedIn')==True:
        mydb = mysql.connector.connect(
            host="localhost",
            user="root", 
            password="root",
            database="GERT"
        )
    
        mycursor = mydb.cursor()
        sql="SELECT * FROM SavedSearches WHERE OwnerID=%s;"
        value=[str(session['uid'])]
        mycursor.execute(sql,value)
    
        myresult = mycursor.fetchall()
    
        return render_template('saved.html',result=myresult)
    else:
        return redirect(url_for("loginPage"))
    


@app.route('/view/', methods = ['GET','POST'])
def view():
    if session.get('LoggedIn')==True:
        ID=request.args.get('ID',None)
        filename=""
        
        mydb = mysql.connector.connect(
            host="localhost",
            user="root", 
            password="root",
            database="GERT"
        )
    
        mycursor = mydb.cursor()
        sql="SELECT * FROM SavedSearches WHERE SearchID=%s;"
        value=[ID]
        mycursor.execute(sql,value)
        
        myresult = mycursor.fetchall()
        for row in myresult:
            filename=row[3]
        
        
        downloadpath="/home/ubuntu/data/"
        downloadpath+=str(session['uid'])
        downloadpath+=filename
        grbs=pygrib.open(downloadpath)
        grb=grbs.read()
        return render_template('view.html', download=downloadpath)
    else:
        return redirect(url_for("loginPage"))

@app.route('/searchData/', methods = ['GET', 'POST'])
def searchData():
    lat1=float(request.values.get('lat'))
    long1=float(request.values.get('long'))+180
    lat2=float(request.values.get('lat2'))
    long2=float(request.values.get('long2'))+180
    
    path=request.values.get('path')
    grbs=pygrib.open(path)
    grb=grbs.read()[0]
    data=grb.data(lat1=lat1,lat2=lat2,lon1=long1,lon2=long2)
    
    return str(grb)
    
    
@app.route('/processLogin/', methods = ['GET', 'POST'])
def processLogin():
    stringRow = ""
    mydb = mysql.connector.connect(
        host="localhost",
        user="root", 
        password="root",
        database="GERT"
    )
    
    mycursor = mydb.cursor()

    mycursor.execute("SELECT * FROM Users")
    myresult = mycursor.fetchall()
    
    for row in myresult:
        if(request.values.get('uName').lower() == row[1].lower()):
            if(request.values.get('pWord') ==  row[2]):
                session['uid']=row[0]
                session['uName']=row[1]
                session['Email']=row[3]
                session['LoggedIn']=True
                return('true')
    return('false')

@app.route('/processAPICall/', methods = ['GET', 'POST'])
def processAPICall():
    dataName = request.values.get('datastoreName')
    datepicker1 = request.values.get('datepicker1')
    datepicker2 = request.values.get('datepicker2')
    time  = request.values.get('time')
    variables = request.values.get('variables')
    carbonmonoxide = request.values.get('carbonmonoxide')
    nitrogendioxide  = request.values.get('nitrogendioxide')
    sulphurdioxide  = request.values.get('sulphurdioxide')
    methane  = request.values.get('methane')
    leadtimeHour  = request.values.get('leadtimeHour')
    fileName = request.values.get('fileName')
    fileFormat = request.values.get('fileFormat')
    
    if fileName=="":
        fileName="Default"
    SaveName=fileName+"."+fileFormat
    downloadpath="/home/ubuntu/data/"
    downloadpath+=str(session['uid'])
    downloadpath+=SaveName
    
    datestring=datepicker1+"/"+datepicker2
    variables=[]
    if carbonmonoxide=="true":
        variables.append("total_column_carbon_monoxide")
    if nitrogendioxide=="true":
        variables.append("total_column_nitrogen_dioxide")
    if sulphurdioxide=="true":
        variables.append("total_column_sulphur_dioxide")
    if methane=="true":
        variables.append("total_column_methane")
    
    requestdict={'date': datestring,'format': fileFormat, 'time': time, 'variable': variables ,'leadtime_hour': leadtimeHour, 'type': 'forecast',}
    
    c = cdsapi.Client()

    c.retrieve(dataName,requestdict,downloadpath)
    mydb = mysql.connector.connect(
        host="localhost",
        user="root", 
        password="root",
        database="GERT"
    )
    
    mycursor = mydb.cursor()
    mycursor.execute("SELECT MAX(SearchID) AS maximum FROM SavedSearches")
    result = mycursor.fetchall()
    maximum=0
    for i in result:
        maximum= float(i[0])
    SaveID=maximum+1
    sql="INSERT INTO SavedSearches (SearchID, Name, OwnerID, Filename) VALUES (%s,%s,%s,%s);"
    values=(SaveID,fileName,session['uid'],SaveName)
    mycursor.execute(sql, values)
    mydb.commit()

    
    return(str(SaveID))

@app.route('/logout/')
def logout():
    session.clear()
    return redirect(url_for("loginPage"))




if __name__ == '__main__':
    app.run(debug=True)
 

