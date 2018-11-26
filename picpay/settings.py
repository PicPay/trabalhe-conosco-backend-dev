#!/usr/bin/env python
# -*- coding: utf-8 -*-

import os
import sys
import multiprocessing
from picpay.memoryCheck import memoryCheck

__author__ = 'Roberto Morati <robertomorati@gmail.com>'
__copyright__ = ' Copyright (c) 2018'
__version__ = '0.0.1'


if 'runserver' in sys.argv:
    DEBUG = True
else:
    DEBUG = True

# Build paths inside the project like this: os.path.join(BASE_DIR, ...)
PROJECT_DIR = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
BASE_DIR = os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))

# Quick-start development settings - unsuitable for production
# See https://docs.djangoproject.com/en/1.10/howto/deployment/checklist/

# SECURITY WARNING: keep the secret key used in production secret!
SECRET_KEY = 'ekm8r87z3ui3al&f3fx+)%$36pe%jy7k*c9y*$8(via!8n+_ul'

# TODO: change
ALLOWED_HOSTS = ['*']


# Application definition

INSTALLED_APPS = [
    'django.contrib.admin',
    'django.contrib.auth',
    'django.contrib.contenttypes',
    'django.contrib.sessions',
    'django.contrib.messages',
    'django.contrib.staticfiles',
    'picpay',
    'django_elasticsearch_dsl',
    'debug_toolbar',
    'rest_framework',
    'rest_framework_swagger',
    'compressor',
]

MIDDLEWARE = [
    'django.middleware.security.SecurityMiddleware',
    'django.contrib.sessions.middleware.SessionMiddleware',
    'django.middleware.common.CommonMiddleware',
    'django.middleware.csrf.CsrfViewMiddleware',
    'django.contrib.auth.middleware.AuthenticationMiddleware',
    'django.contrib.messages.middleware.MessageMiddleware',
    'django.middleware.clickjacking.XFrameOptionsMiddleware',
    'debug_toolbar.middleware.DebugToolbarMiddleware',
]


DEBUG_TOOLBAR_PANELS = [
    'debug_toolbar.panels.versions.VersionsPanel',
    'debug_toolbar.panels.timer.TimerPanel',
    'debug_toolbar.panels.settings.SettingsPanel',
    'debug_toolbar.panels.headers.HeadersPanel',
    'debug_toolbar.panels.request.RequestPanel',
    'debug_toolbar.panels.sql.SQLPanel',
    'debug_toolbar.panels.staticfiles.StaticFilesPanel',
    'debug_toolbar.panels.templates.TemplatesPanel',
    'debug_toolbar.panels.cache.CachePanel',
    'debug_toolbar.panels.signals.SignalsPanel',
    'debug_toolbar.panels.logging.LoggingPanel',
    'debug_toolbar.panels.redirects.RedirectsPanel',
]

ROOT_URLCONF = 'picpay.urls'

TEMPLATES = [
    {
        'BACKEND': 'django.template.backends.django.DjangoTemplates',
        'DIRS': [],
        'APP_DIRS': True,
        'OPTIONS': {
            'context_processors': [
                'django.template.context_processors.debug',
                'django.template.context_processors.request',
                'django.contrib.auth.context_processors.auth',
                'django.contrib.messages.context_processors.messages',
            ],
        },
    },
]

WSGI_APPLICATION = 'picpay.wsgi.application'


# Database
# https://docs.djangoproject.com/en/1.10/ref/settings/#databases
# https://docs.djangoproject.com/en/1.11/ref/settings/
# The lifetime of a database connection, in seconds. Use 0 to
# close database connections at the end of each request — Django’s historical
# behavior — and None for unlimited persistent connections.
CONN_MAX_AGE = 10

# File ENV is not used
"""
if 'DB_NAME' in os.environ:
    DATABASES = {
        'default': {
            'ENGINE': 'django.db.backends.mysql',
            'NAME': os.environ['DB_NAME'],
            'USER': os.environ['DB_USER'],
            'PASSWORD': os.environ['DB_PASS'],
            'HOST': os.environ['DB_HOST'],
            'PORT': os.environ['DB_PORT'],
        }
    }
"""
DATABASES = {
    'default': {
        'ENGINE': 'django.db.backends.mysql',
        'NAME': 'database_name',
        'USER': 'user',
        'PASSWORD': 'pwd',
        'HOST': 'host',
        'PORT': '3306',
    }
}

# Password validation
# https://docs.djangoproject.com/en/1.10/ref/settings/#auth-password-validators

AUTH_PASSWORD_VALIDATORS = [
    {
        'NAME': 'django.contrib.auth.password_validation.UserAttributeSimilarityValidator',
    },
    {
        'NAME': 'django.contrib.auth.password_validation.MinimumLengthValidator',
    },
    {
        'NAME': 'django.contrib.auth.password_validation.CommonPasswordValidator',
    },
    {
        'NAME': 'django.contrib.auth.password_validation.NumericPasswordValidator',
    },
]


# Internationalization
# https://docs.djangoproject.com/en/1.10/topics/i18n/

LANGUAGE_CODE = 'en-us'

TIME_ZONE = 'UTC'

USE_I18N = True

USE_L10N = True

USE_TZ = True

REST_FRAMEWORK = {
    # Use Django's standard `django.contrib.auth` permissions,
    # or allow read-only access for unauthenticated users.
    'DEFAULT_PERMISSION_CLASSES': [
        'rest_framework.permissions.DjangoModelPermissionsOrAnonReadOnly'
    ]
}

# Static files (CSS, JavaScript, Images)
# https://docs.djangoproject.com/en/1.10/howto/static-files/

STATIC_URL = '/static/'

STATIC_ROOT = PROJECT_DIR + '/static/'

# STATICFILES_DIRS = [
#    os.path.join(PROJECT_DIR, 'static'),
# ]

STATICFILES_FINDERS = (
    'django.contrib.staticfiles.finders.FileSystemFinder',
    'django.contrib.staticfiles.finders.AppDirectoriesFinder',
    # other finders..
    'compressor.finders.CompressorFinder',
)

ELASTICSEARCH_DSL = {
    'default': {
        'hosts': 'IP:PORT'
    },
}

# The LIMIT_BULK_CREATE is based on RAM
"""
try:
    WSINFO = os.environ['WS_INFO']
    WSSEARCH = os.environ['WS_SEARCH']
    PATH_FILE = PROJECT_DIR + os.environ['USERS_CSV']
    PATH_FILE_PRIORITY = PROJECT_DIR + os.environ['LIST_RELEVANCIA']
    LIMIT_BULK_CREATE = os.environ['LIMIT']
except Exception as ex:
"""
WSINFO = '<url:port>/api/v1/info/'
WSSEARCH = '<url:port>/api/v1/users/'
PATH_FILE = PROJECT_DIR + '/users.csv'
PATH_FILE_PRIORITY = PROJECT_DIR + '/lista_relevancia.csv'
LIMIT_BULK_CREATE = 10000

THREAD_PARALLEL_BULK = int(multiprocessing.cpu_count()) / 2
CHUNK_SIZE = 10000
MAX_CHUNK_BYTES = int(memoryCheck().value * 0.10) * 1024 * 1024
