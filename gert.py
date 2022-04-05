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
        if(request.values.get('uName') == row[1]):
            if(request.values.get('pWord') ==  row[2]):
                session['uName']=row[1]
                session['Email']=row[3]
                session['LoggedIn']=True
                return('true')
    return('false')

@app.route('/processAPICall/', methods = ['GET', 'POST'])
def processAPICall():
    c = cdsapi.Client()

    c.retrieve(
        'cams-global-reanalysis-eac4',
        {
            'date': '2021-06-30/2021-06-30',
            'format': 'grib',
            'time': '03:00',
            'variable': 'total_column_nitrogen_dioxide',
        },
        
        '/home/ubuntu/data/download.grib')
    
    return('true')

@app.route('/logout/')
def logout():
    session.clear()
    return redirect(url_for("loginPage"))



if __name__ == '__main__':
    app.run(debug=True)
    
