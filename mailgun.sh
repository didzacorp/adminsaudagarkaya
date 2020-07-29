curl -s --user 'api:key-8a14df0c7f3b08f3d96693a347e78454' \
    https://api.mailgun.net/v3/nini-sia-punk.rocks/messages \
    -F from='vulnwalker <vulnwalker@elderscode.org>' \
    -F to='vulnwalker@tuyul.online' \
    -F subject='Hello' \
    -F text='Testing some Mailgun awesomeness!'
