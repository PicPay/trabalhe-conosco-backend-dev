#!/bin/sh

echo "Collect the static files"
python manage.py collectstatic --noinput

echo "Database migrations"
python manage.py migrate

echo "Loading priority list and users"

python manage.py load_priority
python manage.py load_users_batch


echo "Indexing users"
python manage.py create_index
curl -XPUT 'elasticsearch:9200/pcusers-index/_settings' -d '{ "index.number_of_replicas" : 0 }'
curl -XPUT 'elasticsearch:9200/pcusers-index/_settings' -d '{ "index.refresh_interval" : "-1" }'	
python manage.py index

echo "Setup number of replicas and  refresh interval"
curl -XPUT 'elasticsearch:9200/pcusers-index/_settings' -d '{ "index.number_of_replicas" : 1 }'
curl -XPUT 'elasticsearch:9200/pcusers-index/_settings' -d '{ "index.refresh_interval" : "30s" }'
	
echo "Setup max result window with 8078162"
curl -XPUT 'elasticsearch:9200/pcusers-index/_settings?preserve_existing=true' -d '{"index.max_result_window" : "8078162" }'


exec "$@"
