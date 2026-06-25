#!/bin/bash
# chmod +x scripts/dev.sh

set -e

echo "Starting Local PHP server..."

cd "$(dirname "$0")/.."
/Applications/XAMPP/bin/php -S 0.0.0.0:8000 