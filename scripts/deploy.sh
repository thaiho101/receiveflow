#!/bin/bash

set -e

PROJECT_DIR="/home/pi/personalDev/receiveflow"

echo "=== ReceiveFlow Deployment Started ==="
cd "$PROJECT_DIR"

git fetch origin 

git reset --hard origin/main

git log --oneline -1

echo "=== ReceiveFlow Deployment Completed Successfully ==="