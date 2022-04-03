#! /usr/bin/python3.8


import logging

import sys

logging.basicConfig(stream=sys.stderr)

sys.path.insert(0, '/home/ubuntu/GERT')

from gert import app as application

application.secret_key = 'Gertool31'

