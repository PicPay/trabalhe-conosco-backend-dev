# Set the base image to use to Ubuntu
FROM python:3.5.3-alpine

MAINTAINER Roberto Morati <robertomorati@gmail.com>

# Local directory with project source
RUN mkdir -p /var/www/picpay
ENV HOME=/var/www/picpay


WORKDIR $HOME

# Update the default application repository sources list
RUN apk update
RUN apk upgrade
RUN apk add --no-cache python3 python-dev python3-dev mysql-client build-base gettext py-mysqldb wget ca-certificates mariadb-dev libffi-dev
RUN pip3 install --upgrade pip
RUN pip install gunicorn django==1.11 

COPY requirements/requirements.txt $HOME
COPY manage.py $HOME

RUN mkdir media static logs
VOLUME ["$HOME/media/", "$HOME/logs/","$HOME/static/"]

RUN wget https://s3.amazonaws.com/careers-picpay/users.csv.gz


COPY . $HOME

# Install Python dependencies
RUN pip install -r $HOME/requirements.txt
# EXPOSE 22/tcp 80/tcp 8000/tcp
#RUN chmod 755 /sbin/docker-entrypoint.sh
#ENTRYPOINT ["/sbin/docker-entrypoint.sh"]
