from transformers import BloomTokenizerFast, BloomForCausalLM  # Cambiamos GPT-2 por BLOOM

# En la función load_model:
def load_model():
    global model, tokenizer, model_loading
    model_loading = True
    try:
        tokenizer = BloomTokenizerFast.from_pretrained("bigscience/bloom-560m")
        model = BloomForCausalLM.from_pretrained("bigscience/bloom-560m")
        model.eval()
    except Exception as e:
        print(f"Error loading model: {e}")
    finally:
        model_loading = False
