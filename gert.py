from flask import Flask, render_template, request, redirect, url_for, session
import cdsapi


app= Flask(__name__)
@app.route('/')
def home():
    return render_template('home.html')

@app.route('/profile/')
def profile():
    return render_template('profile.html')

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
    data =  request.values.get('uName')
    return(data)



if __name__ == '__main__':
    app.run(debug=True)
    
