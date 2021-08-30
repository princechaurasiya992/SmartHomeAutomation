from pigpio_dht import DHT11
import sys
import pymysql
import pymysql.cursors

gpio = 18 # BCM Numbering
sensor = DHT11(gpio)
result = sensor.read()

hostname = 'localhost'
username = 'admin'
password = 'prince'
database = 'smart_home_automation'

query = "INSERT INTO temp_and_hum (data) VALUES (%s)"
args = (format(result))

conn = pymysql.connect(host=hostname, user=username, passwd=password, db=database)
cursor = conn.cursor()
cursor.execute(query, args)
conn.commit()
cursor.close()
conn.close()