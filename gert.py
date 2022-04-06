from flask import Flask, render_template, request, redirect, url_for, session
import cdsapi
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
    carbondioxide  = request.values.get('carbondioxide')
    leadtimeHour  = request.values.get('leadtimeHour')
    fileName = request.values.get('fileName')
    fileFormat = request.values.get('fileFormat')
    datestring=datepicker1+"/"+datepicker2
    variables=[]
    if carbonmonoxide=="true":
        variables.append("total_column_carbon_monoxide")
    if nitrogendioxide=="true":
        variables.append("total_column_nitrogen_dioxide")
    if sulphurdioxide=="true":
        variables.append("total_column_sulphur_dioxide")
    if carbondioxide=="true":
        variables.append("total_column_carbon_dioxide")
    
    requestdict={'date': datestring,'format': fileFormat, 'time': time, 'variable': variables}
    
    c = cdsapi.Client()

    c.retrieve(
        dataName,
        requestdict},
        
        '/home/ubuntu/data/download.grib')
    
    return(dataName + str(datepicker1) + str(datepicker2) + str(time) + str(carbonmonoxide) + str(nitrogendioxide)
          + str(sulphurdioxide) + str(carbondioxide) + str(leadtimeHour) + str(variables) + fileName + fileFormat)

@app.route('/logout/')
def logout():
    session.clear()
    return redirect(url_for("loginPage"))



if __name__ == '__main__':
    app.run(debug=True)
    
