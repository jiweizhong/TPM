#!/bin/sh
wget https://github.com/jiweizhong/TPM/master/tpm.php
wget https://github.com/jiweizhong/TPM/master/tpm.example.conf
rm -r -f /usr/local/bin/tpm
cp ./tpm.php /usr/local/bin/tpm
chmod +x /usr/local/bin/tpm
rm -r -f ./tpm.php