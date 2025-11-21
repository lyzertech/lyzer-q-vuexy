from pymodbus.client.sync import ModbusTcpClient
from pymodbus.payload import BinaryPayloadDecoder
from pymodbus.constants import Endian

# Connect to Modbus TCP device
client = ModbusTcpClient("192.168.2.96", port=502)

if client.connect():
    print("Connected to Modbus device")

    # Read 66 registers starting at 16384 (covers all 33 floats)
    rr = client.read_holding_registers(16384, 66, unit=1)

    if not rr.isError():
        decoder = BinaryPayloadDecoder.fromRegisters(
            rr.registers,
            byteorder=Endian.Big,   # adjust if values look wrong
            wordorder=Endian.Big
        )

        labels = [
            # Voltage-Current
            "Frequency",
            "Phase 1 Voltage",
            "Phase 2 Voltage",
            "Phase 3 Voltage",
            "Average Phase Voltage",
            "Line Voltage 1-2",
            "Line Voltage 2-3",
            "Line Voltage 3-1",
            "Average Line Voltage",
            "Total Phase A Current",
            "Total Phase B Current",
            "Total Phase C Current",
            "Average Phase Current",
            "Neutral Current",
            
            # Power
            "Phase A Power",
            "Phase B Power",
            "Phase C Power",
            "Total System Power",
            "Phase A Reactive Power",
            "Phase B Reactive Power",
            "Phase C Reactive Power",
            "Total Reactive Power",
            "Phase A Apparent Power",
            "Phase B Apparent Power",
            "Phase C Apparent Power",
            "Total Apparent Power",
            "Phase A Power Factor",
            "Phase B Power Factor",
            "Phase C Power Factor",
            "Total Power Factor",
            "Voltage Unbalance",
            "Current Unbalance",
            "Load Characteristic",
        ]

        values = [round(decoder.decode_32bit_float(), 2) for _ in labels]

        for name, val in zip(labels, values):
            print(f"{name}: {val}")

    else:
        print("Read error:", rr)

    client.close()
else:
    print("Unable to connect to Modbus device")
