CREATE EXTENSION IF NOT EXISTS pgagent;

CREATE DATABASE pgagent;

-- Connect to the pgagent database
\c pgagent;

-- Create the pgagent extension
CREATE EXTENSION IF NOT EXISTS pgagent;

-- Create the pgagent user
CREATE USER pgagent SUPERUSER;

-- Set the password for the pgagent user (replace 'your_password' with an actual password)
ALTER USER pgagent WITH PASSWORD 'your_password';

-- Create the pgagent schema
CREATE SCHEMA pgagent;

-- Create the pgagent tables
\i /usr/share/pgagent.sql;