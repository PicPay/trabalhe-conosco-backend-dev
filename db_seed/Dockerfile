FROM mongo
RUN apt update -y && apt install wget -y
COPY . /db_seed
CMD [ "sh", "/db_seed/seed.sh" ]
