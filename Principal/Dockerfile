FROM microsoft/dotnet:runtime

ENV PICPAY_DB_HOST=172.17.0.2

COPY / /app/

EXPOSE 80 8080

ENTRYPOINT [ "dotnet",  "app/PicPay.dll", "docker"]