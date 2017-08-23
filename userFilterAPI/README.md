# Backend

Backend desenvolvido em Python framework Django. A idéa foi criar um campo chamando relevância para o usuário e alterar os usuários
dos arquivos lista_relevancia_1 com a relevância 1 e lista_relevancia_2 com a relevância 2 e ordenar sequindo esse campo. 

comandos para rodar localmente:
- python manage.py makemigrations
- python manage.py migrate 
- python manage.py runserver

comandos para importação do banco:
- python importcsv.py
- python updateRelevanciaUsers.py

necessário instalar:
- python
- django
- rest_framework
- django-cors-headers