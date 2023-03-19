## ByteDash - Dashboard template

ByteDash has ben created by ByteTeam.pl for non-commercial usage. If you like to use this dashboard for your own buisness like SaaS, contact with ByteTeam.pl to buy License!
[![License](https://i.creativecommons.org/l/by-nc-sa/4.0/88x31.png)](http://creativecommons.org/licenses/by-nc-sa/4.0/)

## Authors

- [@Francuz](https://www.github.com/FrancuzDEV)

## Deployment

To deploy this project run

Ubuntu 18.04/20.04/22.04

```bash
    apt-get update && apt-get upgrade
    apt install apache2
    apt install php
    apt install mysql-server
    mysql_secure_installation
    cd /var/www/html
    git clone https://github.com/FrancuzDEV/bytedash.git
    cd bytedash-main
    mv * ../
    cd ..
    rm -r bytedash-main
    chmod 777 *
```

## Used By

This project is used by the following companies:

- DeltaCloud.eu (closed)
- ByteCloud.pl

## Roadmap

- SOON

- SOON

## Feedback

If you have any feedback, please reach out to us at contact@bytecloud.pl

## FAQ

#### How much i must pay to get License to commercial use this Dashboard?

There is no one answer to that question. Contact with us on contact@bytecloud.pl or checkout our website https://app.byteteam.pl/

#### Can XXX be added to dashboard?

If you like to share with us your opinion about new updates, contact with us on contact@bytecloud.pl or on our [Discord](https://discord.gg/vv2vWuawQj)

## API Reference (SOON) (ADMIN)

#### Get User Data

```http
  POST /api/users/{id}/
```

| Parameter | Type     | Description                                        |
| :-------- | :------- | :------------------------------------------------- |
| `apiKey`  | `string` | **Required**. API Key generated in Admin Dashboard |

#### Get User Personal Data

```http
  POST /api/users/{id}/data
```

| Parameter | Type     | Description                                        |
| :-------- | :------- | :------------------------------------------------- |
| `apiKey`  | `string` | **Required**. API Key generated in Admin Dashboard |

## API Reference (SOON) (CLIENT)

#### Get User Data

```http
  POST /api/user
```

| Parameter | Type     | Description                                         |
| :-------- | :------- | :-------------------------------------------------- |
| `apiKey`  | `string` | **Required**. API Key generated in Client Dashboard |

#### Get User Personal Data

```http
  POST /api/user/data
```

| Parameter | Type     | Description                                         |
| :-------- | :------- | :-------------------------------------------------- |
| `apiKey`  | `string` | **Required**. API Key generated in Client Dashboard |
