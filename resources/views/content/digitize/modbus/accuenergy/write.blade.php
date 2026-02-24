<form method="POST" action="{{ url('modbus/accuenergy/write') }}">
    @csrf
    Address: <input name="address" type="number" />
    Value: <input name="value" type="number" step="any" />
    <button>Write</button>
</form>
