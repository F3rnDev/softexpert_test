#!/bin/bash

# Configurações de conexão ao banco de dados
DB_HOST="localhost"
DB_USER="postgres"
DB_PASSWORD="postgres"
DB_NAME="postgres"
DB_PORT="6086"

# Nome do arquivo de backup
BACKUP_FILENAME="backup.sql"

# Exportar a base de dados
pg_dump -h $DB_HOST -p $DB_PORT -U $DB_USER -d $DB_NAME -F c -f $BACKUP_FILENAME

echo "Base de dados exportada com sucesso para $BACKUP_FILENAME"