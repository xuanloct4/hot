

参考
https://oopsr.github.io/2016/06/20/voip/
```
1、将之前生成的voip.cer SSL证书双击导入钥匙串
2、打开钥匙串访问，在证书中找到对应voip.cer生成的证书，右键导出并选择.p12格式,这里我们命名为voippush.p12,这里导出需要输入密码(随意输入，别忘记了)。
3、目前我们有两个文件，voip.cer SSL证书和voippush.p12私钥，新建文件夹命名为VoIP、并保存两个文件到VoIP文件夹。
4、把.cer的SSL证书转换为.pem文件，打开终端命令行cd到VoIP文件夹、执行以下命令
openssl x509 -in voip.cer  -inform der -out VoiPCert.pem
5、把.p12私钥转换成.pem文件，执行以下命令（这里需要输入之前导出设置的密码）
openssl pkcs12 -nocerts -out VoIPKey.pem -in voippush.p12
6、再把生成的两个.pem整合到一个.pem文件中
cat VoiPCert.pem VoIPKey.pem > ck.pem
最终生成的ck.pem文件一般就是服务器用来推送的。
```

# 生成PEM

```
openssl x509 -in voip_services.cer  -inform der -out VoiPCert.pem
```

```
openssl pkcs12 -nocerts -out VoIPKey.pem -in voip.p12
*这里会输入 pass phrase ，在pushkit 里面会使用
```

```
cat VoiPCert.pem VoIPKey.pem > ck.pem
```