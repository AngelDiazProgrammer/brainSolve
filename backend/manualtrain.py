from transformers import GPT2LMHeadModel, GPT2Tokenizer, Trainer, TrainingArguments
from datasets import load_dataset, DatasetDict

# Cargar el modelo y el tokenizador
model_name = "gpt2"
model = GPT2LMHeadModel.from_pretrained(model_name)
tokenizer = GPT2Tokenizer.from_pretrained(model_name)

# Definir el token de padding
tokenizer.pad_token = tokenizer.eos_token

# Cargar y preparar los datos
dataset = load_dataset("text", data_files={"train": "primer_entrenamiento.txt"})
def tokenize_function(examples):
    encodings = tokenizer(examples["text"], truncation=True, padding="max_length", max_length=512)
    encodings['labels'] = encodings['input_ids'].copy()  # Añadir labels
    return encodings

# Tokenizar los datos
tokenized_datasets = dataset.map(tokenize_function, batched=True)

# Dividir en entrenamiento y evaluación
split_datasets = tokenized_datasets["train"].train_test_split(test_size=0.1)
dataset_dict = DatasetDict({
    'train': split_datasets['train'],
    'eval': split_datasets['test']
})

# Configuración del entrenamiento
training_args = TrainingArguments(
    output_dir="./results",
    evaluation_strategy="epoch",
    learning_rate=2e-5,
    per_device_train_batch_size=4,
    num_train_epochs=3,  # Ajusta según sea necesario
    weight_decay=0.01,
)

# Inicializar el entrenador
trainer = Trainer(
    model=model,
    args=training_args,
    train_dataset=dataset_dict['train'],
    eval_dataset=dataset_dict['eval']
)

# Entrenar el modelo
trainer.train()

# Guardar el modelo ajustado
model.save_pretrained("./fine-tuned-gpt2")
tokenizer.save_pretrained("./fine-tuned-gpt2")
