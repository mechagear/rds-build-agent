#!/bin/bash
set -e

SCRIPT_PATH=$(dirname $(readlink -f $0))

. $SCRIPT_PATH/../librc

packagename=$1
packageversion=$2

package="$packagename-$packageversion"

if isnull $packagename || isnull $packageversion; then
    echo "$0  ${GREEN}install${NORMAL}  packagename packageversion"
    exitf
fi

execute_concurrent $packagename "sudo mkdir /var/pkg/$package/ && sudo chown release:release /var/pkg/$package/"

for server in $(execute_concurrent $packagename 'echo ""')
do
        # Trim ":" symbol
        server=${server:0:-1}
        echo "[" `date` "] Deploy to $server..."
        rsync -rlpEAXogtz /home/release/buildroot/$package/var/pkg/$package/ $server:/var/pkg/$package || exit 1
done
echo -n "[" `date` "] finished"