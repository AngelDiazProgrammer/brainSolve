<link rel="stylesheet" href="{{ asset('css/general.css') }}">
<form action="{{ route('train-model') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div>
        <label for="data_file">Archivo de entrenamiento:</label>
        <input type="file" name="data_file" id="data_file" required>
    </div>
    <div>
        <label for="learning_rate">Learning Rate:</label>
        <input type="number" step="0.00001" name="learning_rate" id="learning_rate" value="0.00002" required>
    </div>
    <div>
        <label for="num_train_epochs">Número de Epochs:</label>
        <input type="number" name="num_train_epochs" id="num_train_epochs" value="3" required>
    </div>
    <div>
        <label for="batch_size">Batch Size:</label>
        <input type="number" name="batch_size" id="batch_size" value="4" required>
    </div>
    <div>
        <label for="weight_decay">Weight Decay:</label>
        <input type="number" step="0.0001" name="weight_decay" id="weight_decay" value="0.01" required>
    </div>
    <button type="submit">Entrenar Modelo</button>
</form>
