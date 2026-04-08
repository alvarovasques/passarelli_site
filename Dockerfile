FROM php:7.4-apache

# Habilitar o mod_rewrite do Apache
RUN a2enmod rewrite

# Instalar extensões mysqli e pdo_mysql necessárias no projeto
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copiar os arquivos do site
# A pasta public_html/public_html é a raiz dos documentos web neste projeto
COPY ./public_html/public_html/ /var/www/html/

# Expor porta web padrão
EXPOSE 80
