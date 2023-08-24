#!/bin/bash

# Configurações de conexão ao banco de dados
DB_HOST="localhost"
DB_USER="postgres"
DB_PASSWORD="postgres"
DB_NAME="postgres"
DB_PORT="6086"

# Nome do arquivo de backup
BACKUP_FILE="backup.sql"

# Importar a base de dados a partir do arquivo usando pg_restore
echo "Importando a base de dados..."
pg_restore -h $DB_HOST -p $DB_PORT -U $DB_USER -d $DB_NAME -v $BACKUP_FILE

echo "Importação concluída!"