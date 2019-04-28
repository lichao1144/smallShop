<?php
	return [
		//应用ID,您的APPID。
		'app_id' => "2016092600598020",
		'seller_id' => "2088102177300090",

		//商户私钥
		'merchant_private_key' => "MIIEowIBAAKCAQEAv+E3Uu/UKHReMPNDdIw/zhLfSnGPK97qh2S3tu5B/JHbH5PSz5eFOfWiwwUoroL8Xf07hc+3iLnxecxl8nfJiB4wgho2+/VVmzPgRow4ApU0BXusjlZnzOzf4B4NNAdGc8yNTxN4GLlT/QB2lZBnm6wikxpi8K1FKx8tM4BhRx+jyvUGsm+odXHWaY6l7CVpg59M77ipdNqv5WmkC2J89uhrD6Hr15HIuc7zENubemognv636VwVmrj6RbYYMnCfw7UnpuMTZp6x9F26FGI3aP1NKS0zuR5CuNHgmEKEovTt+MxIhOcQSsafeC0RilvF2xB/V5FXbgeSX+/xpHtL2wIDAQABAoIBAQCvRTIb+CZ7rZA8dnkvhMzjmCmO/pwhHsZsVnvaBVkRNMpL1ePC7E0t3EqIibXXcp7D3AT6/fpQUklZUHPvP6w/QhRdQ0Tmcft4gbJjvsGK2m9ics30VskKT3VQayL0W5DnRfnuOYKCUwd9G2c2x2lcsagDZx7pady8vwWy/ZneNFudWJ4GCt7KM1YPCK5Nm/7DCjsSjLeKkKJrsSGWflCuZhHcnGwlH09g0xYFeO2v0YFOCPZ5Zte8+BsTELPJfP3jEwc+9AnNuTQCPTcBN2gs5teSVQHtavv3asxGI+EhI+FI07xRdd0LGheE6sAzt+0cmJzpqUzrQUT9/wkfRW9BAoGBAOEy8qbkycW329QWz+v2NZaGxgBxzMd9pvx+YGgiaS9+uFnENrUlJBN6A2VqsYQD03xtj1CeYLirpoHq2olevUXUkyEX1yfnIMwPclxjqKEhM+X7OCRkC3f8YtrYpRNypwzVd5VYYCBXejPXIpqzIUkG6JB4VtCQdqO6rRbq65/lAoGBANofoyakhc83+8BJPWLvfs6UIAVQFGnjdia1d2eZVNH7ddKKVwaoht4y9Jx+hLyqFEsKoV3FrG8D337o61WDrZKExHLuLEe5Fw1+5bdC2K3DzixmdDzbS79D4TyeZUVglqt5qFuSZdPb76nc5nPWM5uQoil/7LzDKcBK/uGTAwC/AoGAH94PzGIv01TTPM4FmkR7DNQBjOqNqeU0DiLsDZBhBiGOgNVtUHDzC/aGKIHSoPXRpZfzYdsnoLpZk6TiS/ImIo2UTGiNP85LK9U7v6syn6qNJ4xHQ48MuGv0qTdjFL9yuDQ0+eNJpwn59wAIm4+htC3QFzGQR29J+p1eBRI1SakCgYAQWS6xRsOAtIF5+ANR1wF6GkAMJeRhy1qfrBo2+ZcR5fb+wL+lEByLquYKlLD+MwEyXqmZjadO6stlh6+byTLJOIpA0vkepxDDQi+VfL0gyPw697LenNEglMXc9UJB4OtqDsQ/mMlpB6L+6D+djwBvOHfvBFeKDlaiwvw3i/09oQKBgDhRyOeHN54mWyiuxSLhWAKs0DBYFThv+5X4cGF76CHXhpL321y8OT2vVlbRQrKWhliA+iGlo3Z/5sI1sAA6OCT8LngY3lUC1WTv5m4NQU5lzHBlHayyQLXEK+EU+hlROkDSKGhkOK76CjpkznhVc9Vzj2E8tiKqz+F1HCj9fWcK",
		
		//异步通知地址
		'notify_url' => "http://www.smallShop.com/returnAlipayB",
		
		//同步跳转
		// 'return_url' => "http://localhost/alipay/return_url.php",
		'return_url' => "http://www.smallShop.com/returnAlipay",
		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA0q4G761Qyc2YNAgeVjQhecMtqPpAChlI9tpDoIick3hvGamgw7RO7vZZbhjtsa3WqXWIyttMHepU0pJHCbLNobtYRt54aCM3hQuoxjCjYX1lDWzbTxCmcq72pZ3x1AWniBoTdsscpCnhoCTRIa7E09P9p6cG+mBwd5aemNlPV5xgFI3XgyBhoeSp4tcPktuv7rZZcmtAshWlEc4T9MAB4s7v9P6WcDu+BOzMvLahhEeH7qmS8rDL7g7MQQaPVjIhcUAykD9bsylkKyfY8+jv108A7kSN0b8NWUoW5kXHXezCQEIify6kCOQVO1o3qU1QWGXgvF0J80PHRsmi9ytt3QIDAQAB",

	];