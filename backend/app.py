from flask import Flask, request, jsonify
from transformers import GPT2LMHeadModel, GPT2Tokenizer

app = Flask(__name__)

# Carga del modelo GPT-2 y el tokenizador
tokenizer = GPT2Tokenizer.from_pretrained("./fine-tuned-gpt2")
model = GPT2LMHeadModel.from_pretrained("./fine-tuned-gpt2")

# Configuración del modelo
model.eval()

# Ruta para recibir solicitudes de generación de texto
@app.route("/generate", methods=["POST"])
def generate_text():
    data = request.get_json()
    prompt = data["prompt"]

    # Generar texto basado en el prompt utilizando el modelo GPT-2
    input_ids = tokenizer.encode(prompt, return_tensors="pt")
    output = model.generate(input_ids, max_length=100, num_return_sequences=1, temperature=0.7)
    generated_text = tokenizer.decode(output[0], skip_special_tokens=True)

    return jsonify({"generated_text": generated_text})

if __name__ == "__main__":
    app.run(debug=True)
