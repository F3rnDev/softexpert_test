## 1 - Como subir o ambiente
Pre-requisito: docker e docker compose.

##### ATENÇÃO: Verifique se o docker está sendo executado, esse projeto foi desenvolvido no windows utilizando wsl2.

Execute o comando abaixo para subir o ambiente
```
sh utils/start-docker-compose.sh
```

Para acessar o frontend da aplicação, acesse http://localhost

O backend desenvolvido em php roda em http://localhost:8080

utilizamos o servidor nginx

<!-- ## 2 - Criar as tabelas no banco de dados
Arquivo de configuração se encontra neste local
applications\php1\public\createTables.php

Para criar as tabelas no banco de dados, acesse http://localhost:8080/createTables.php -->

## 2 - Exportar e importar os dados da tabela
Pre-requisito: nescessário ter instalado na sua máquina o postgres-client para que os comandos pg_dump e pg_restore funcionem corretamente.

```
sudo apt-get install postgresql-client
```

Caso você deseje fazer um backup dos seus dados, execute o comando abaixo:
```
sh utils/export-database.sh
```

Caso você deseje importar os dados de exemplo da aplicação, execute o comando abaixo:
```
sh utils/import-database.sh
```

## 3 - Exemplos de utilização do software
Esta aplicação utilizam o mesmo modelo de design no ambiente de frontend

