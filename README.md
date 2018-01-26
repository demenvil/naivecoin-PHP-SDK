# PHP SDK for naivecoin
This is the naivecoin PHP SDK. This SDK contains methods for easily interacting with the Naivecoin API
```
A[LOCAL] -- Call API --> B((SDK))
B --> C[NODE]
C --> A
```
# Requirements
The SDK requires PHP 7.0+

# Use

Initialize Class Naive Coin, set host and port with __construct


##### public headers

    array header



#### Methods

* * * * *

##### public __construct

    constructor

    @param string $host_api

    @param int $port

##### public __set

    Set attribute

    @param string $property

    @param type $value

    @return $this

##### public getAllBlock

    Get all blocks

    @return type

##### public getLatestBlock

    Get the latest block

    @return type

##### public getBlockByIndex

    Get block by index

    @param int $index

    @return type

##### public getBlockByHash

    Get block by hash

    @param string $hash

    @return type

##### public getBlockByTransactionsId

    Get a transaction from some block

    @param string $transactionId

    @return type

##### public getAllTransaction

    Get all transactions

    @return type

##### public getUnspentTransactions

    Get unspent transactions

    @return type

##### public getAllWallets

    Get all wallets

    @return type

##### public createWallet

    Create a wallet from a password

    @param type $password

    @return type

##### public getWalletById

    Get wallet by id

    @param type $walletId

    @return type

##### public getAllAdresseOfWallet

    Get all addresses of a wallet

    @param type $walletId

    @return type

##### public createAddress

    Create a new address

    @param type $password

    @param type $walledId

    @return type

##### public withdrawal

    Create a new transaction

    @param string $walletId

    @param string $password

    @param string $from

    @param string $to

    @param int $amount

    @return type

##### public getBalance

   Get the balance of a given address

    @param type $addressId

    @return type

##### public getAllpeers

    Get all peers connected to node

    @return type

##### public connectNewPeer

    Connects a new peer to node

    @param string $url

    @return type

##### public getConfirmation

    Get how many confirmations a block has

    @param string $transactionId

    @return type
