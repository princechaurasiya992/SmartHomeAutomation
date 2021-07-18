from picamera import PiCamera
import time
import datetime
import pymysql
import pymysql.cursors

camera = PiCamera()

hostname = 'localhost'
username = 'admin'
password = 'prince'
database = 'smart_home_automation'

query = "INSERT INTO pictures (photo) VALUES (%s)"
filename = datetime.datetime.now().strftime("%Y-%m-%d_%H.%M.%S.jpg")
camera.capture("/var/www/html/SmartHomeAutomation/img/pictures/{}".format(filename))
    
args = (filename)

conn = pymysql.connect(host=hostname, user=username, passwd=password, db=database)
cursor = conn.cursor()
cursor.execute(query, args)
conn.commit()
cursor.close()
conn.close()
    

