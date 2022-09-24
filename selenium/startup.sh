#!/bin/sh

# Set directory with drivers
cd /var

# Startup Selenum Server
java -jar selenium-server-4.4.0.jar standalone --port $1 &
