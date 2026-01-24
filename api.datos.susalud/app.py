from flask import Flask, jsonify, request
from flask_cors import CORS
from datetime import datetime
import json
import threading

app = Flask(__name__)
CORS(app, resources={r"/api/*": {"origins": "*"}})  # Permite el acceso a todas las rutas bajo /api

# Ruta archivo json _ dispositivos.json
lock = threading.Lock()  # Crear un lock para manejar la concurrencia

# Función para cargar los datos del archivo JSON
def cargar_dispositivos():
    with open('dispositivos.json', 'r') as f:
        return json.load(f)

# Función para guardar los datos en el archivo JSON
def guardar_dispositivos(data):
    with open('dispositivos.json', 'w') as f:
        json.dump(data, f, indent=4)

# Cargar los datos de inicio (cuando el servidor se inicia)
dispositivos_data = cargar_dispositivos()


# Ruta del home
@app.route('/')
def home():
    return "API Susalud - Estatus: OK"

# Ruta para obtener los datos de geolocalización
@app.route('/api/susalud/geoData', methods=['GET'])
def obtener_geoData():
    id_dispositivo = request.args.get('id')
    # Cargamos los datos desde el archivo para obtener los datos más recientes
    dispositivos_data = cargar_dispositivos()
    if id_dispositivo in dispositivos_data:
        return jsonify(dispositivos_data[id_dispositivo])
    else:
        return jsonify({"error": "Dispositivo no encontrado"}), 404

# Ruta para actualizar los datos de geolocalización
@app.route('/api/susalud/updateGeoData', methods=['POST'])
def actualizar_geoData():
    data = request.get_json()
    if 'latitud' in data and 'longitud' in data and 'id' in data:
        id_dispositivo = data['id']
        
        # Bloqueamos el acceso al archivo mientras actualizamos los datos
        with lock:
            # Cargamos los datos desde el archivo
            dispositivos_data = cargar_dispositivos()
            if id_dispositivo in dispositivos_data:
                # Si el dispositivo existe, actualizamos los datos
                if 'descripcion' in data:
                    dispositivos_data[id_dispositivo]['descripcion'] = data['descripcion'] # Actualizamos la descripción
                dispositivos_data[id_dispositivo]['latitud'] = data['latitud']
                dispositivos_data[id_dispositivo]['longitud'] = data['longitud']
                dispositivos_data[id_dispositivo]['altitud'] = data['altitud']
                dispositivos_data[id_dispositivo]['satelites'] = data['satelites']
                dispositivos_data[id_dispositivo]['hdop'] = data['hdop']
                dispositivos_data[id_dispositivo]['timestamp'] = data['timestamp']

            else:
                # Si el dispositivo no existe, lo agregamos
                dispositivos_data[id_dispositivo] = {
                    'nombre': f'Dispositivo GPS {id_dispositivo}',
                    'descripcion': 'Dispositivo propiedad de NilBraslet - Susalud',
                    'latitud': data['latitud'],
                    'longitud': data['longitud'],
                    'altitud': data['altitud'],
                    'satelites': data['satelites'],
                    'hdop': data['hdop'],
                    'timestamp': data['timestamp']
                }

            # Guardamos los cambios en el archivo
            guardar_dispositivos(dispositivos_data)
            return jsonify({"message": "Datos actualizados o dispositivo agregado con éxito", "data": dispositivos_data[id_dispositivo]})
    else:
        return jsonify({"error": "Faltan datos de latitud, longitud o id"}), 400

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)