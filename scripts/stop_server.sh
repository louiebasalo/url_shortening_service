#!/bin/bash

isExistApp=$(pgrep httpd)
echo "isExistApp: $isExistApp"

if [[ -n $isExistApp ]]; then
    echo "Stopping httpd service..."
    service httpd stop
fi