from flask import Flask, request, jsonify
from transformers import GPT2LMHeadModel, GPT2Tokenizer
from train_gpt2 import train_model  
import threading

app = Flask(__name__)

# Inicialización de variables para el modelo y el tokenizador
model = None
tokenizer = None
model_loading = False  # Bandera para indicar si el modelo se está cargando

# Crear un lock para controlar el acceso
lock = threading.Lock()

def load_model():
    global model, tokenizer, model_loading
    model_loading = True  # Establecer la bandera a True al iniciar la carga
    try:
        tokenizer = GPT2Tokenizer.from_pretrained("./fine-tuned-gpt2")
        model = GPT2LMHeadModel.from_pretrained("./fine-tuned-gpt2")
        model.eval()
    except Exception as e:
        print(f"Error loading model: {e}")
    finally:
        model_loading = False  # Establecer la bandera a False una vez que la carga se complete

def load_model_async():
    threading.Thread(target=load_model, daemon=True).start()

# Cargar el modelo al inicio de la aplicación
load_model()

# Ruta para recibir solicitudes de generación de texto
@app.route("/generate", methods=["POST"])
def generate_text():
    if model_loading:
        return jsonify({"error": "El modelo está siendo cargado, intenta más tarde."}), 503


    with lock:  # Adquirir el lock
        data = request.get_json()
        prompt = data["prompt"]

        try:
            # Generar texto basado en el prompt utilizando el modelo GPT-2
            input_ids = tokenizer.encode(prompt, return_tensors="pt")
            output = model.generate(input_ids, max_length=100, num_return_sequences=1, temperature=0.7)
            generated_text = tokenizer.decode(output[0], skip_special_tokens=True)
        except Exception as e:
            return jsonify({"error": str(e)}), 500

    return jsonify({"generated_text": generated_text})

@app.route('/train-gpt2', methods=['POST'])
def train_gpt2():
    global model, tokenizer  # Para permitir la modificación de las variables globales
    with lock:  # Adquirir el lock
        data = request.form  # Obtiene los datos del formulario
        learning_rate = float(data.get('learning_rate'))
        num_train_epochs = int(data.get('num_train_epochs'))
        batch_size = int(data.get('batch_size'))
        weight_decay = float(data.get('weight_decay'))
        
        # Obtener el archivo directamente sin usar 'with'
        data_file = request.files['data_file']

        try:
            # Llama a la función de entrenamiento
            train_model(learning_rate, num_train_epochs, batch_size, weight_decay, data_file)
            load_model_async()  # Cargar el modelo en un hilo separado
        except ValueError as ve:
            return jsonify({"error": f"Valor incorrecto: {str(ve)}"}), 400
        except Exception as e:
            return jsonify({"error": f"Error durante el entrenamiento: {str(e)}"}), 500

    return jsonify({"message": "Modelo entrenado y recargado"})


if __name__ == "__main__":
    app.run(debug=True)