<link rel="stylesheet" href="{{ asset('css/general.css') }}">
<form action="{{ route('rollback-model') }}" method="POST">
    @csrf
    <div>
        <label for="backup_version">Versión de Backup (ejemplo: backup-gpt2-20241027-120000):</label>
        <input type="text" name="backup_version" id="backup_version" required>
    </div>
    <button type="submit">Realizar Rollback</button>
</form>
