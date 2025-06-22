from flask import Flask, render_template, jsonify
import mysql.connector
import pandas as pd
from fbprophet import Prophet
import json

app = Flask(__name__)

# Configuración de la base de datos
DB_CONFIG = {
    'host': 'localhost',
    'user': 'erick',
    'password': 'Evimu997261',
    'database': '4550502_prueba'
}

def get_product_data():
    conn = mysql.connector.connect(**DB_CONFIG)
    query = """
        SELECT fecha_cosecha, cantidad 
        FROM productos 
        WHERE fecha_cosecha IS NOT NULL
    """
    df = pd.read_sql(query, conn)
    conn.close()
    df.columns = ['ds', 'y']  # Renombrar columnas para Prophet
    df['ds'] = pd.to_datetime(df['ds'])
    return df

@app.route('/')
def index():
    return '''
    <!DOCTYPE html>
    <html>
    <head>
        <title>Predicción de Productos</title>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>
    <body>
        <h1>Predicción de Productos para 2025</h1>
        <canvas id="predictionChart"></canvas>
        <script>
            fetch('/predict')
                .then(response => response.json())
                .then(data => {
                    const ctx = document.getElementById('predictionChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data.dates,
                            datasets: [{
                                label: 'Predicción de Cantidad',
                                data: data.prediction,
                                borderColor: 'blue',
                                fill: false
                            }]
                        }
                    });
                });
        </script>
    </body>
    </html>
    '''

@app.route('/predict')
def predict():
    df = get_product_data()
    model = Prophet()
    model.fit(df)
    future = model.make_future_dataframe(periods=365, freq='D')
    forecast = model.predict(future)
    
    data = {
        'dates': forecast['ds'].dt.strftime('%Y-%m-%d').tolist(),
        'prediction': forecast['yhat'].tolist()
    }
    return jsonify(data)

if __name__ == '__main__':
    app.run(debug=True)
