import os 
import shutil
import time
import logging
from transformers import GPT2LMHeadModel, GPT2Tokenizer, Trainer, TrainingArguments
from datasets import load_dataset, DatasetDict

# Configurar logging
logging.basicConfig(level=logging.INFO)

def train_model(learning_rate, num_train_epochs, batch_size, weight_decay, data_file):
    model_dir = "./fine-tuned-gpt2"
    backup_dir = f"./backup-gpt2-{time.strftime('%Y%m%d-%H%M%S')}"

    if os.path.exists(model_dir):
        shutil.copytree(model_dir, backup_dir)
        logging.info(f"Backup del modelo anterior guardado en {backup_dir}")

    # Guardar el archivo de datos de entrenamiento
    data_file_path = "dataset.txt"
    data_file.save(data_file_path)

    if os.path.getsize(data_file_path) == 0:
        logging.error("El archivo de datos está vacío.")
        return

    # Cargar el modelo y el tokenizador
    model_name = "gpt2"
    model = GPT2LMHeadModel.from_pretrained(model_name)
    tokenizer = GPT2Tokenizer.from_pretrained(model_name)
    tokenizer.pad_token = tokenizer.eos_token

    # Cargar y preparar los datos
    dataset = load_dataset("text", data_files={"train": data_file_path})

    def tokenize_function(examples):
        encodings = tokenizer(examples["text"], truncation=True, padding="max_length", max_length=512)
        encodings['labels'] = encodings['input_ids'].copy()
        return encodings

    tokenized_datasets = dataset.map(tokenize_function, batched=True)
    split_datasets = tokenized_datasets["train"].train_test_split(test_size=0.1)
    dataset_dict = DatasetDict({
        'train': split_datasets['train'],
        'eval': split_datasets['test']
    })

    # Configuración del entrenamiento
   
    training_args = TrainingArguments(
    output_dir=model_dir,
    eval_strategy="epoch",  
    learning_rate=learning_rate,
    per_device_train_batch_size=batch_size,
    num_train_epochs=num_train_epochs,
    weight_decay=weight_decay,
    logging_dir='./logs',
    logging_steps=10,
)


    trainer = Trainer(
        model=model,
        args=training_args,
        train_dataset=dataset_dict['train'],
        eval_dataset=dataset_dict['eval']
    )

    # Entrenar el modelo
    trainer.train()
    model.save_pretrained(model_dir)
    tokenizer.save_pretrained(model_dir)

    logging.info(f"Entrenamiento completado. Backup creado en {backup_dir}")

if __name__ == "__main__":
    pass