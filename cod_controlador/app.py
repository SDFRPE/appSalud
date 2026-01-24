import time
from machine import Pin, UART
from micropyGPS import MicropyGPS

# Configura el UART para comunicarse con el GPS
uart = UART(2, baudrate=9600, tx=17, rx=16)  # Cambia TX/RX si necesitas otros pines

# Inicializa la librería MicropyGPS
gps = MicropyGPS(-5)  # Cambia el offset según la zona horaria (ej: -5 para Lima)

def update_gps():
    while uart.any():
        data = uart.read(1)  # Lee un byte de datos
        gps.update(data)     # Actualiza los datos GPS con el byte leído

while True:
    update_gps()
    if gps.latitude and gps.longitude:
        # Convierte latitud y longitud a grados decimales
        lat = gps.latitude[0] + gps.latitude[1] / 60.0
        if gps.latitude[2] == 'S':
            lat = -lat
        lon = gps.longitude[0] + gps.longitude[1] / 60.0
        if gps.longitude[2] == 'W':
            lon = -lon

        print("Latitud:", lat)
        print("Longitud:", lon)
    else:
        print("Esperando señal GPS...")

    time.sleep(1)  # Actualiza cada segundo