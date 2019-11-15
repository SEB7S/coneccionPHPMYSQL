import pymysql
import RPi.GPIO as GPIO
import time
from datetime import date
from datetime import datetime



#instrucciones para el funcionamiento del sensor y la captura de datos
pir_sensor = 11 #conexion del sensor
piezo = 7 # este puerto de salida


GPIO.setmode(GPIO.BOARD)

GPIO.setup(piezo,GPIO.OUT)

GPIO.setup(pir_sensor, GPIO.IN)
fecha = ''
hora = ''
current_state = 0
try:
    while True:
        time.sleep(0.1)
        current_state = GPIO.input(pir_sensor)
	
        if current_state == 1:
            print("Movimiento detectado ")
	    GPIO.output(piezo,True)
	    print(current_state)
	    GPIO.output(piezo,False)
            time.sleep(5)
	    #Base de datos insertar
	    db=pymysql.connect(host='localhost',user='root',password='12345',db='soproyecto')
	    cursor = db.cursor()
	    insertar= "INSERT INTO datos(fecha,hora) VALUES (%s, %s);"
	    cursor.execute(insertar,(date.today(), datetime.now()))
	    db.commit()
	    data = cursor.fetchone()
	    print('datos insertados')
	    db.close()
except KeyboardInterrupt:
    pass
finally:
    GPIO.cleanup()


#funcion para conectar e insertar datos a la db
def insertData(fecha, hora):
	try:	
		x='conexion correcta'
		conexion=pymysql.connect(host='localhost',user='root',password='12345',db='soproyecto')
		try:
			with conexion.cursor() as cursor:
				#cursor.execute("insert into prueba(cod,nom) values ('822011', 'Pepito Perez')")
				insertar= "INSERT INTO datos(fecha,hora) VALUES (%s, %s);"
				cursor.execute(insertar,(fecha, hora))
			conexion.commit()
			print('datos insertados')
		finally:
			conexion.close()
		
		print(x)
	except (pymysql.err.OperationalError, pymysql.err.InternalError) as e:
		print(e)



