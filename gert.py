from flask import Flask, render_template, request, redirect, url_for, session

app= Flask(__name__)
@app.route('/')
def home():
    return render_template('home.html')

@app.route('/profile/')
def profile():
    return render_template('profile.html')

@app.route('/signUp/')
def signUp():
    return render_template('GertSignUp.html')

@app.route('/login/')
def loginPage():
    return render_template('login.html')

@app.route('/process/login', methods = ['POST'])
def login():
    uName = request.json['uName']
    password = request.json['pWord']
    return(uName + password)

if __name__ == '__main__':
    app.run(debug=True)
    
