# Instalación

## Instalar y configurar nodejs
1. Descargar [Node](https://nodejs.org/es/)
2. Descargar [Yarn](https://yarnpkg.com/lang/en/docs/install/#windows-stable)

## Instalar Composer
1. Descargar [Composer](https://getcomposer.org/)

# Poniendo a funcionar nuestro entorno
1. En la raiz del proyecto, ejecutar el siguiente comando ``composer install``
2. En Crear el archivo .env copiado del .env.example.
3. Ejecutar el Yarn usando el siguiente comando  ``yarn install``
4. Una vez terminada la instalacion de las dependencias de node, ejecutar el comando ``yarn watch`` el cual transpilara las fuentes creadas en vue de la parte frontend
5. Para levantar nuestro entorno solo debemos ejecutar el comando ``php artisan serve`` desde la raiz del proyecto el cual desplegara el proyecto en localhost:8000
6. Realizar la importacion de la base de datos mysql el cual se encuentra en la ruta "./database/banco_de_dados_exported.sql", dicho archivo tiene la exportacion completa del dump

## Nota
Es importante ejecutar el comando ``yarn watch`` para la transpilacion de los js de vue y los sass