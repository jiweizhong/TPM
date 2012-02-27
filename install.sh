#!/bin/sh
wget https://raw.github.com/jiweizhong/TPM/master/tpm.php --no-check-certificate
wget https://raw.github.com/jiweizhong/TPM/master/tpm.example.conf --no-check-certificate
rm -r -f /usr/local/bin/tpm
cp ./tpm.php /usr/local/bin/tpm
chmod +x /usr/local/bin/tpm
rm -r -f ./tpm.php