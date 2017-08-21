#!/bin/bash
if [ -f /import.lock ]; then # se existir o arquivo de lock, entao a importacao esta em andamento
  exit 1 #starting
else
  exit 0 #health
fi
