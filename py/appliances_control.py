import RPi.GPIO as GPIO
import sys

GPIO.setmode(GPIO.BCM)
GPIO.setwarnings(False)

# Set specified GPIO pins to OUT
gRelayNumList = [4, 17, 27, 22]
for pinNum in gRelayNumList:
    GPIO.setup(pinNum, GPIO.OUT)

# Argument values, num will be GPIO list key and cmd will be for GPIO state
args = sys.argv
btn_id = int(args[1])
state = int(args[2])

# Turn ON the relay by setting to output to 0 (relay used during test is active low, 0/False will turn ON a switch)
if state == 1:
    # Turn ON
    GPIO.output(gRelayNumList[btn_id], 0)
elif state == 0:
    # Turn OFF
    GPIO.output(gRelayNumList[btn_id], 1)
