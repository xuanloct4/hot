# php-pushKit

Apple PushKit VoIP demo

苹果 PushKit 中 VoIP的推送Demo

## Useage

```
require "./PushKit.php";

$pushKit = new PushKit();
//notice: use pushKit token not device token
$pushKit->VoIP('abe51a6666666666666969ff7a2f56f', [
    'title' => 'This is title',
    'text' => 'This is text',
]);
```

## Notice

PushKit has it's own certificate.(not same with apns certificate)

PushKit 有自己的cer，不要和apns混淆。

PushKit token has it's own token.(not same with device token)

PushKit 有自己的token，也不要和device token 混淆

**USE PUSHKIT TOKEN**

**一定注意要使用PushKit 的token**

## Reference resources

https://oopsr.github.io/2016/06/20/voip/

https://stackoverflow.com/questions/27245808/implement-pushkit-and-test-in-development-behavior

https://www.jianshu.com/p/afc8de658931

http://blog.csdn.net/heyufei/article/details/53616961?utm_source=itdadao&utm_medium=referral#%E6%B5%8B%E8%AF%95push