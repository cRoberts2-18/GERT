from flask import Flask, render_template, request, redirect, url_for, session
import cdsapi
import pygrib
import mysql.connector
import camslib
import json


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


@app.route('/showMap/', methods = ['GET','POST'])
def showMap():
    camslib.get_projection_map("", "")
    return("hello")
    
    
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
        grb=grbs.read(1)[0]
        return render_template('view.html', download=downloadpath)
    else:
        return redirect(url_for("loginPage"))

@app.route('/searchData/', methods = ['GET', 'POST'])
def searchData():
    lat1=float(request.values.get('lat'))
    long1=float(request.values.get('long'))
    lat2=float(request.values.get('lat2'))
    long2=float(request.values.get('long2'))
    path=request.values.get('path')
    SearchID=request.values.get('ID')
    date1=str(request.values.get('date1'))
    date2=str(request.values.get('date2'))
    date1=int(date1.replace("-",""))
    date2=int(date2.replace("-",""))
    dates=list(range(date1,date2+1))
    no2=0
    so2=0
    co=0
    ch4=0
    no2Data=""
    so2Data=""
    coData=""
    ch4Data=""
    no2Dates=[]
    so2Dates=[]
    coDates=[]
    ch4Dates=[]
    latData=""
    longData=""
    dataDict={}
    mydb = mysql.connector.connect(
            host="localhost",
            user="root", 
            password="root",
            database="GERT"
        )
    
    mycursor = mydb.cursor()
    sql="SELECT * FROM SavedSearches WHERE SearchID=%s;"
    value=[str(SearchID)]
    mycursor.execute(sql,value)
    
    myresult = mycursor.fetchall()
    for row in myresult:
        no2=row[4]
        so2=row[5]
        co=row[6]
        ch4=row[7]
    grbs=pygrib.open(path)
    if no2==1:
        no2Dates=grbs.select(name="Total column Nitrogen dioxide", date = (dates))
        no2Data="Nitrogen Dioxide: "+str(grbs.select(name="Total column Nitrogen dioxide")[0].data(lat1=lat1,lat2=lat2,lon1=long1,lon2=long2)[0])
        latData="Latitude: "+str(grbs.select(name="Total column Nitrogen dioxide")[0].data(lat1=lat1,lat2=lat2,lon1=long1,lon2=long2)[1])
        longData="Longitude: "+str(grbs.select(name="Total column Nitrogen dioxide")[0].data(lat1=lat1,lat2=lat2,lon1=long1,lon2=long2)[2])
        
    if so2==1:
        so2Dates=grbs.select(name="Total column Sulphur dioxide", date = (dates))
        so2Data="Sulphur Dioxide: "+str(grbs.select(name="Total column Sulphur dioxide")[0].data(lat1=lat1,lat2=lat2,lon1=long1,lon2=long2)[0])
        latData="Latitude: "+str(grbs.select(name="Total column Sulphur dioxide")[0].data(lat1=lat1,lat2=lat2,lon1=long1,lon2=long2)[1])
        longData="Longitude: "+str(grbs.select(name="Total column Sulphur dioxide")[0].data(lat1=lat1,lat2=lat2,lon1=long1,lon2=long2)[2])
     
    if co==1:
        coDates=grbs.select(name="Total column Carbon monoxide", date = (dates))
        coData="Carbon Monoxide: "+str(grbs.select(name="Total column Carbon monoxide")[0].data(lat1=lat1,lat2=lat2,lon1=long1,lon2=long2)[0])
        latData="Latitude: "+str(grbs.select(name="Total column Carbon monoxide")[0].data(lat1=lat1,lat2=lat2,lon1=long1,lon2=long2)[1])
        longData="Longitude: "+str(grbs.select(name="Total column Carbon monoxide")[0].data(lat1=lat1,lat2=lat2,lon1=long1,lon2=long2)[2])
     
    if ch4==1:
        ch4Dates=grbs.select(name="Total column methane", date = (dates))
        ch4Data="Methane: "+str(grbs.select(name="Total column methane")[0].data(lat1=lat1,lat2=lat2,lon1=long1,lon2=long2)[0])
        latData="Latitude: "+str(grbs.select(name="Total column methane")[0].data(lat1=lat1,lat2=lat2,lon1=long1,lon2=long2)[1])
        longData="Longitude: "+str(grbs.select(name="Total column methane")[0].data(lat1=lat1,lat2=lat2,lon1=long1,lon2=long2)[2])
    
    
    count=0
    for i in range(len(dates)):
        first=0
        data=latData+"!"+longData+"!"

        if no2==1:
            try:
                data+="Nitrogen Dioxide: "+str(no2Dates[count].data(lat1=lat1,lat2=lat2,lon1=long1,lon2=long2)[0])
            except:
                print("")
            first=1
        if so2==1:
            if first==0:
                try:
                    data+="Sulphur Dioxide: "+str(so2Dates[count].data(lat1=lat1,lat2=lat2,lon1=long1,lon2=long2)[0])
                except:
                    print("")
                first=1
            else:
                try:
                    data+="!"+"Sulphur Dioxide: "+str(so2Dates[count].data(lat1=lat1,lat2=lat2,lon1=long1,lon2=long2)[0])
                except:
                    print("")
        if co==1:
            if first==0:
                try:
                    data+="Carbon Monoxide: "+str(coDates[count].data(lat1=lat1,lat2=lat2,lon1=long1,lon2=long2)[0])
                except:
                    print("")
                first=1
            else:
                try:
                    data+="!"+"Carbon Monoxide: "+str(coDates[count].data(lat1=lat1,lat2=lat2,lon1=long1,lon2=long2)[0])
                except:
                    print("")
        if ch4==1:
            if first==0:
                try:
                    data+="Methane: "+str(ch4Dates[count].data(lat1=lat1,lat2=lat2,lon1=long1,lon2=long2)[0])
                except:
                    print("")
                first=1
            else:
                try:
                    data+="!"+"Methane: "+str(ch4Dates[count].data(lat1=lat1,lat2=lat2,lon1=long1,lon2=long2)[0])
                except:
                    print("")
        count+=1
        try:
            dataDict[dates[i]]=data
        except:
            print("")
    return dataDict
    
    
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
    no2=0
    so2=0
    co=0
    ch4=0
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
        co=1
    if nitrogendioxide=="true":
        variables.append("total_column_nitrogen_dioxide")
        no2=1
    if sulphurdioxide=="true":
        variables.append("total_column_sulphur_dioxide")
        so2=1
    if methane=="true":
        variables.append("total_column_methane")
        ch4=1
    
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
    sql="INSERT INTO SavedSearches (SearchID, Name, OwnerID, Filename, NO2, SO2, CO, CH4, StartDate, EndDate) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s);"
    values=(SaveID,fileName,session['uid'],SaveName,no2,so2,co,ch4,datepicker1,datepicker2)
    mycursor.execute(sql, values)
    mydb.commit()

    
    return(str(SaveID))

@app.route('/getGif/', methods = ['GET', 'POST'])
def getGif():
    path=request.values.get('path')
    SearchID=request.values.get('ID')
    camslib.download_images(path, "/home/ubuntu/data/", "AFRICA", "gist_ncar", "", "giffy")
    return(path + SearchID)
    

@app.route('/logout/')
def logout():
    session.clear()
    return redirect(url_for("loginPage"))




if __name__ == '__main__':
    app.run(debug=True)
 

