from flask import Flask, render_template, request, redirect, url_for, session

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

@app.route('/login/')
def loginPage():
    return render_template('login.html')

@app.route('/processLogin', methods = ['POST'])
def login():
    uName = request.json['uName']
    password = request.json['pWord']
    return(uName + password)

@app.route('/signUp.php')
def phpScript():
    out = sp.run(["php","signUp.php"], stdout = sp.PIPE)
    return out.stdout

if __name__ == '__main__':
    app.run(debug=True)
    
