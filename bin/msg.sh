#!/usr/bin/env bash

## Helper to display coloured status messages

while (( "$#" )); do
    case ${1} in
        -w|--wait)
            shift
            printf "\033[32m${1}\033[0m ... "
            ;;

        -d|--done)
            shift
            printf "\033[36m${1}\033[0m\n"
            ;;

        -e|--error)
            shift
            printf "\033[37;41m${1}\033[0m\n" >&2
            ;;

        *)
            printf "\033[32m${1}\033[0m\n"
            ;;
    esac

    shift
done
