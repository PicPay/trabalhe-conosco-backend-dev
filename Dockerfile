# Set the base image to use to Apline
FROM python:3.5.3-alpine

MAINTAINER Roberto Morati <robertomorati@gmail.com>

# Local directory with project source
RUN mkdir -p /var/www/picpay
ENV HOME=/var/www/picpay


WORKDIR $HOME

# Update the default application repository sources list
RUN apk update
RUN apk upgrade
RUN apk add --no-cache python3 python-dev python3-dev mysql-client build-base gettext py-mysqldb wget ca-certificates mariadb-dev libffi-dev tar 
RUN apk add --update curl gcc g++
RUN pip3 install --upgrade pip
RUN pip install gunicorn
COPY requirements/requirements.txt $HOME
COPY manage.py $HOME

RUN mkdir media static logs
VOLUME ["$HOME/media/", "$HOME/logs/","$HOME/static/"]

COPY django-entrypoint.sh /sbin/django-entrypoint.sh

COPY . $HOME

# Install Python dependencies
RUN pip install -r $HOME/requirements.txt

RUN pip install numpy==1.15.4
RUN pip install pandas==0.23.2


RUN chmod 755 /sbin/django-entrypoint.sh

# ENTRYPOINT ["/sbin/django-entrypoint.sh"]
# RUN "/sbin/django-entrypoint.sh"
