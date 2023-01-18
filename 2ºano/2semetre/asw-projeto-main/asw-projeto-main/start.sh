#!/bin/bash
port=$1;

re='^[0-9]+$'
if ! [[ $port =~ $re ]] ; then
   echo "error: Port is not a number" >&2; exit 1
fi

if ! [[ $port -lt 65536 && $port -gt 0 ]] ; then
   echo "error: Port is not in range" >&2; exit 1
fi

php -S 0.0.0.0:$port