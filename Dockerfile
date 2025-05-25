FROM php:8.0-cli
COPY . /app
WORKDIR /app
CMD ["php", "-S", "0.0.0.0:10000"]
