# Use an official PostgreSQL image as the base image
FROM postgres:latest

# Install pgAgent
RUN apt-get update \
    && apt-get install -y pgagent \
    && rm -rf /var/lib/apt/lists/*

# Expose the PostgreSQL port
EXPOSE 5432

# Set the default user, password, and database
ENV POSTGRES_USER postgres
ENV POSTGRES_PASSWORD postgres
ENV POSTGRES_DB postgres

# Copy the SQL script to create the required database and extension
COPY init_pgagent.sql /docker-entrypoint-initdb.d/