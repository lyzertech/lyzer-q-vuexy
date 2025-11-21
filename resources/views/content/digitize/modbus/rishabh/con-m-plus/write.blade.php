<form method="POST" action="{{ url('modbus/write') }}">
    @csrf
    IP: <input name="ip" />
    Address: <input name="address" />
    Value: <input name="value" />
    <button>Write</button>
</form>
