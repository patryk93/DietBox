#/bin/bash

print_help() {
    echo 'Dostępne opcje:'
    echo '''
        1. start - Uruchom projekt
        2. close - Zamknij projekt
        3. clean - Usuń istniejące projektowe kontenery
    '''
}

expression=$1

case $expression in
    'rebuild')
    docker-compose down -v
    docker-compose up
    # sleep 60

    # create.
    ;;
    'start')
    docker-compose up --force-recreate
    ;;
    'close')
    docker-compose down
    ;;
    'clean')
    docker rm $(docker container ls -aq -f "name=dieta-pudelkowa*")
    ;;
    *)
    print_help
    ;;
esac
