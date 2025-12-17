#!/bin/bash
set -e

# This script runs when the PostgreSQL container starts for the first time.
# It creates additional databases needed for the application.

psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" <<-EOSQL
    -- Create the testing database
    CREATE DATABASE cat_testing;

    -- Grant all privileges to the user
    GRANT ALL PRIVILEGES ON DATABASE cat_testing TO $POSTGRES_USER;
EOSQL

echo "Test database 'cat_testing' created successfully."
