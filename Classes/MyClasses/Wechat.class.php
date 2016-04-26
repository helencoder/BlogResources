<?php
/**
 * Author: helen
 * CreateTime: 2015/12/9 20:14
 * description: ΢�Ź���ƽ̨�ӿ�API
 */
class Wechat{

    /**
     * @FunctionDescription:��֤�����߷�����url��Ч��
     * @Param:token(���� �û��ֶ������������Ϣ)
     * @Return:echostr������ַ�����
     * @Description:
     * @Author:helen zheng
     */
    public function valid($token){
        $echostr = $_GET['echostr'];
        if($this->checkSignature($token)){
            echo $echostr;
            exit;
        }
    }

    /**
     * @FunctionDescription:����signature����
     * @Param:token(���� �û��ֶ������������Ϣ)
     * @Return:true/false
     * @Description:΢�ŷ���������get����signature��timestamp��nonce��echostr�ĸ��������͵��������ṩ��url�����ý��յ��Ĳ���������֤��
     * @Author:helen zheng
     */
    function checkSignature($token){
        /*��ȡ΢�ŷ���ȷ�ϵĲ�����*/
        $signature = $_GET['signature'];    /*΢�ż���ǩ����signature����˿�������д��token�����������е�timestamp������nonce������*/
        $timestamp = $_GET['timestamp'];    /*ʱ��� */
        $nonce = $_GET['nonce'];            /*����� */
        $echostr = $_GET['echostr'];        /*����ַ���*/
        /*����/У������*/
        /*1. ��token��timestamp��nonce�������������ֵ�������*/
        $array = array($token,$timestamp,$nonce);
        sort($array,SORT_STRING);
        /*2. �����������ַ���ƴ�ӳ�һ���ַ�������sha1����*/
        $str = sha1( implode($array) );
        /*3. �����߻�ü��ܺ���ַ�������signature�Աȣ���ʶ��������Դ��΢��*/
        if( $str==$signature && $echostr ){
            return ture;
        }else{
            return false;
        }
    }

    /**
     * @FunctionDescription:��ȡaccess_token
     * @Param:AppID���������û�Ψһƾ֤ ��,AppSecret���������û�Ψһƾ֤��Կ��
     * @Return:access_token�� string��length=117����
     * @Description:access_token�Ĵ洢����Ҫ����512���ַ��ռ䡣access_token����Ч��ĿǰΪ2��Сʱ���趨ʱˢ�£��ظ���ȡ�������ϴλ�ȡ��access_tokenʧЧ��
     * @Author:helen zheng
     */
    public function getToken($appid,$appsecret){
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
        $result = $this->request_get($url);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:��ȡ΢�ŷ�������IP��ַ�б�
     * @Param:access_token(���ںŵ�access_token )
     * @Return:
     * @Description:��ȫ��֤
     * @Author:helen zheng
     */
    public function getWeixinIP($access_token){
        $url = 'https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token='.$access_token;
        $result = $this->request_get($url);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:������Ϣ��Ӧ(�ظ�)�����������Զ���ظ��ӿڡ��������ӿڡ��ͷ��ӿڽ�ϣ�
     * @Param:
     * @Return:������Ϣ����
     * @Description:?����ͨ΢���û������˺ŷ���Ϣʱ��΢�ŷ�������POST��Ϣ��XML���ݰ�����������д��URL�ϡ�
     * @Author:helen zheng
     */
    public function responseMsg(){
        /*1,��ȡ��΢�����͹���post���ݣ�xml��ʽ��*/
        $postArr = $GLOBALS['HTTP_RAW_POST_DATA'];
        /*2,������Ϣ���ͣ������ûظ����ͺ�����*/
        $postObj = simplexml_load_string($postArr);
        /*�ж��û�������Ϣ������(��ͨ��Ϣ���¼�����)*/
        $MsgType = strtolower($postObj->MsgType);
        $Event = strtolower($postObj->Event);
        if(isset($Event)){  /*�¼�����*/
            switch($Event){
                case 'subscribe'            : /*return '�����¼���ɨ���������ά���¼�(�û�δ��ע)��';*/
                    $template = '<xml>
                                    <ToUserName><![CDATA[toUser]]></ToUserName>
                                    <FromUserName><![CDATA[FromUser]]></FromUserName>
                                    <CreateTime>123456789</CreateTime>
                                    <MsgType><![CDATA[event]]></MsgType>
                                    <Event><![CDATA[subscribe]]></Event>
                                </xml>';
                    break;
                case 'unsubscribe'          : /*return 'ȡ�������¼�';*/
                    $template ='<xml>
                                    <ToUserName><![CDATA[toUser]]></ToUserName>
                                    <FromUserName><![CDATA[FromUser]]></FromUserName>
                                    <CreateTime>123456789</CreateTime>
                                    <MsgType><![CDATA[event]]></MsgType>
                                    <Event><![CDATA[unsubscribe]]></Event>
                                </xml>';
                    break;
                case 'scan'                 : /*return 'ɨ���������ά���¼�(�û��ѹ�ע)';*/
                    $template = '<xml>
                                    <ToUserName><![CDATA[toUser]]></ToUserName>
                                    <FromUserName><![CDATA[FromUser]]></FromUserName>
                                    <CreateTime>123456789</CreateTime>
                                    <MsgType><![CDATA[event]]></MsgType>
                                    <Event><![CDATA[subscribe]]></Event>
                                    <EventKey><![CDATA[qrscene_123123]]></EventKey>
                                    <Ticket><![CDATA[TICKET]]></Ticket>
                                </xml>';
                    break;
                case 'location'             : /*return '�ϱ�����λ���¼�';*/
                    $template = '<xml>
                                    <ToUserName><![CDATA[toUser]]></ToUserName>
                                    <FromUserName><![CDATA[fromUser]]></FromUserName>
                                    <CreateTime>123456789</CreateTime>
                                    <MsgType><![CDATA[event]]></MsgType>
                                    <Event><![CDATA[LOCATION]]></Event>
                                    <Latitude>23.137466</Latitude>
                                    <Longitude>113.352425</Longitude>
                                    <Precision>119.385040</Precision>
                                </xml>';
                    break;
                case 'click'                : /*return '�Զ���˵��¼�������˵���ȡ��Ϣʱ���¼����ͣ�';*/
                    $template = '<xml>
                                    <ToUserName><![CDATA[toUser]]></ToUserName>
                                    <FromUserName><![CDATA[FromUser]]></FromUserName>
                                    <CreateTime>123456789</CreateTime>
                                    <MsgType><![CDATA[event]]></MsgType>
                                    <Event><![CDATA[CLICK]]></Event>
                                    <EventKey><![CDATA[EVENTKEY]]></EventKey>
                                </xml>';
                    break;
                case 'view'                 : /*return '�Զ���˵��¼�������˵���ת����ʱ���¼����ͣ�';*/
                    $template = '<xml>
                                    <ToUserName><![CDATA[toUser]]></ToUserName>
                                    <FromUserName><![CDATA[FromUser]]></FromUserName>
                                    <CreateTime>123456789</CreateTime>
                                    <MsgType><![CDATA[event]]></MsgType>
                                    <Event><![CDATA[VIEW]]></Event>
                                    <EventKey><![CDATA[www.qq.com]]></EventKey>
                                </xml>';
                    break;
                case 'scancode_push'        : /*return '�Զ���˵��¼���ɨ�����¼����¼����� ��'*/
                    $template = '<xml>
                                    <ToUserName><![CDATA[gh_e136c6e50636]]></ToUserName>
                                    <FromUserName><![CDATA[oMgHVjngRipVsoxg6TuX3vz6glDg]]></FromUserName>
                                    <CreateTime>1408090502</CreateTime>
                                    <MsgType><![CDATA[event]]></MsgType>
                                    <Event><![CDATA[scancode_push]]></Event>
                                    <EventKey><![CDATA[6]]></EventKey>
                                    <ScanCodeInfo>
                                        <ScanType><![CDATA[qrcode]]></ScanType>
                                        <ScanResult><![CDATA[1]]></ScanResult>
                                    </ScanCodeInfo>
                                </xml>';
                    break;
                case 'scancode_waitmsg'     : /*return '�Զ���˵��¼���ɨ�����¼��ҵ�������Ϣ�����С���ʾ����¼�����  ��'*/
                    $template = '<xml>
                                    <ToUserName><![CDATA[gh_e136c6e50636]]></ToUserName>
                                    <FromUserName><![CDATA[oMgHVjngRipVsoxg6TuX3vz6glDg]]></FromUserName>
                                    <CreateTime>1408090606</CreateTime>
                                    <MsgType><![CDATA[event]]></MsgType>
                                    <Event><![CDATA[scancode_waitmsg]]></Event>
                                    <EventKey><![CDATA[6]]></EventKey>
                                    <ScanCodeInfo>
                                        <ScanType><![CDATA[qrcode]]></ScanType>
                                        <ScanResult><![CDATA[2]]></ScanResult>
                                    </ScanCodeInfo>
                                </xml>';
                    break;
                case 'pic_sysphoto'         : /*return '�Զ���˵��¼�������ϵͳ���շ�ͼ���¼�����  ��'*/
                    $template = '<xml>
                                    <ToUserName><![CDATA[gh_e136c6e50636]]></ToUserName>
                                    <FromUserName><![CDATA[oMgHVjngRipVsoxg6TuX3vz6glDg]]></FromUserName>
                                    <CreateTime>1408090651</CreateTime>
                                    <MsgType><![CDATA[event]]></MsgType>
                                    <Event><![CDATA[pic_sysphoto]]></Event>
                                    <EventKey><![CDATA[6]]></EventKey>
                                    <SendPicsInfo>
                                        <Count>1</Count>
                                        <PicList>
                                            <item>
                                                <PicMd5Sum><![CDATA[1b5f7c23b5bf75682a53e7b6d163e185]]></PicMd5Sum>
                                            </item>
                                        </PicList>
                                    </SendPicsInfo>
                                </xml>';
                    break;
                case 'pic_photo_or_album'   : /*return '�Զ���˵��¼����������ջ�����ᷢͼ���¼����� ��'*/
                    $template = '<xml>
                                    <ToUserName><![CDATA[gh_e136c6e50636]]></ToUserName>
                                    <FromUserName><![CDATA[oMgHVjngRipVsoxg6TuX3vz6glDg]]></FromUserName>
                                    <CreateTime>1408090816</CreateTime>
                                    <MsgType><![CDATA[event]]></MsgType>
                                    <Event><![CDATA[pic_photo_or_album]]></Event>
                                    <EventKey><![CDATA[6]]></EventKey>
                                    <SendPicsInfo>
                                        <Count>1</Count>
                                        <PicList>
                                            <item>
                                                <PicMd5Sum><![CDATA[5a75aaca956d97be686719218f275c6b]]></PicMd5Sum>
                                            </item>
                                        </PicList>
                                    </SendPicsInfo>
                                </xml>';
                    break;
                case 'pic_weixin'           : /*return '�Զ���˵��¼�������΢����ᷢͼ�����¼����� ��'*/
                    $template = '<xml>
                                    <ToUserName><![CDATA[gh_e136c6e50636]]></ToUserName>
                                    <FromUserName><![CDATA[oMgHVjngRipVsoxg6TuX3vz6glDg]]></FromUserName>
                                    <CreateTime>1408090816</CreateTime>
                                    <MsgType><![CDATA[event]]></MsgType>
                                    <Event><![CDATA[pic_weixin]]></Event>
                                    <EventKey><![CDATA[6]]></EventKey>
                                    <SendPicsInfo>
                                        <Count>1</Count>
                                        <PicList>
                                            <item>
                                                <PicMd5Sum><![CDATA[5a75aaca956d97be686719218f275c6b]]></PicMd5Sum>
                                            </item>
                                        </PicList>
                                    </SendPicsInfo>
                                </xml>';
                    break;
                case 'location_select'      : /*return '�Զ���˵��¼�����������λ��ѡ�������¼����ͣ�'*/
                    $template = '<xml>
                                    <ToUserName><![CDATA[gh_e136c6e50636]]></ToUserName>
                                    <FromUserName><![CDATA[oMgHVjngRipVsoxg6TuX3vz6glDg]]></FromUserName>
                                    <CreateTime>1408091189</CreateTime>
                                    <MsgType><![CDATA[event]]></MsgType>
                                    <Event><![CDATA[location_select]]></Event>
                                    <EventKey><![CDATA[6]]></EventKey>
                                    <SendLocationInfo>
                                        <Location_X><![CDATA[23]]></Location_X>
                                        <Location_Y><![CDATA[113]]></Location_Y>
                                        <Scale><![CDATA[15]]></Scale>
                                        <Label><![CDATA[ �����к������ʹ���Է· 106��]]></Label>
                                        <Poiname><![CDATA[]]></Poiname>
                                    </SendLocationInfo>
                                </xml>';
                    break;
                default                     : /*return 'δ֪�¼�����';*/
                    break;
            }
        }else{  /*��ͨ��Ϣ(�Զ��ظ���չ)*/
            switch($MsgType){
                case 'text'       : /*return '�ı���Ϣ';*/
                    $Content = '�����͵�Ϊ�ı�������Ϊ:'.$postObj->Content;
                    break;
                case 'image'      : /*return 'ͼƬ��Ϣ';*/
                    $Content = '�����͵�ΪͼƬ��ͼƬ����Ϊ:'.$postObj->PicUrl;
                    break;
                case 'voice'      : /*return '������Ϣ';*/
                    $Content = '�����͵�Ϊ������ý��IDΪ:'.$postObj->MediaId;
                    break;
                case 'video'      : /*return '��Ƶ��Ϣ';*/
                    $Content = '�����͵�Ϊ��Ƶ��ý��IDΪ:'.$postObj->MediaId;
                    break;
                case 'shortvideo' : /*return 'С��Ƶ��Ϣ';*/
                    $Content = '�����͵�ΪС��Ƶ��ý��IDΪ:'.$postObj->MediaId;
                    break;
                case 'location'   : /*return '����λ����Ϣ';*/
                    $Content = '�����͵�Ϊ����λ����Ϣ��λ��Ϊ: '.$postObj->Label.'γ��Ϊ: '.$postObj->Location_X.'����Ϊ: '.$postObj->Location_Y;
                    break;
                case 'link'       : /*return '������Ϣ';*/
                    $Content = '�����͵�Ϊ������Ϣ������Ϊ: '.$postObj->Title.'����Ϊ: '.$postObj->Description.'���ӵ�ַΪ: '.$postObj->Url;
                    break;
                default           : /*return 'δ֪��Ϣ����';*/
                    $Content = '��Ǹ�����������룡';
                    break;
            }
        }
        /*��Ӧ��Ϣ*/
        $FromUserName = $postObj->ToUserName;
        $ToUserName   = $postObj->FromUserName;
        $MsgType = 'text';  /*��ʱ��Ӧ�������ı���Ϣ����ʽ*/
        $CreateTime = time();
        $template = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <Content><![CDATA[%s]]></Content>
                            </xml>";
        $info = sprintf($template,$ToUserName,$FromUserName,$CreateTime,$MsgType,$Content);
        echo $info;
    }

    /**
     * @FunctionDescription:���ͣ��ظ�����Ϣ
     * @Param:�ظ���Ϣ����(�ظ�ͼ����Ϣ������ӵڶ������� ����Ϊarray �ĸ��ֶΣ�title��description��picUrl��url�� )
     * @Return:
     * @Description:���ݻظ���Ϣѡ�������ͽ����ض����͵Ļظ�
     * @Author:helen zheng
     */
    public function transmitMsg($MsgType,$array=null){
        /*1,��ȡ��΢�����͹���post���ݣ�xml��ʽ��*/
        $postArr = $GLOBALS['HTTP_RAW_POST_DATA'];
        /*2,������Ϣ���ͣ������ûظ����ͺ�����*/
        $postObj = simplexml_load_string($postArr);
        /*�ж��û�������Ϣ������(��ͨ��Ϣ���¼�����)*/
        /*��Ӧ��Ϣ*/
        $FromUserName = $postObj->ToUserName;
        $ToUserName   = $postObj->FromUserName;
        $CreateTime = time();
        switch($MsgType){   /*�ظ���Ϣ*/
            case 'text'       : /*return '�ı���Ϣ';*/
                $Content  = '';
                $template = '<xml>
                                <ToUserName><![CDATA[%s]]></ToUserName>
                                <FromUserName><![CDATA[%s]]></FromUserName>
                                <CreateTime>%s</CreateTime>
                                <MsgType><![CDATA[%s]]></MsgType>
                                <Content><![CDATA[%s]]></Content>
                            </xml>';
                $info = sprintf($template,$ToUserName,$FromUserName,$CreateTime,$MsgType,$Content);
                break;
            case 'image'      : /*return 'ͼƬ��Ϣ';*/
                $MediaId  = '';
                $template = '<xml>
                                <ToUserName><![CDATA[%s]]></ToUserName>
                                <FromUserName><![CDATA[%s]]></FromUserName>
                                <CreateTime>%s</CreateTime>
                                <MsgType><![CDATA[%s]]></MsgType>
                                <Image>
                                    <MediaId><![CDATA[%s]]></MediaId>
                                </Image>
                            </xml>';
                $info = sprintf($template,$ToUserName,$FromUserName,$CreateTime,$MsgType,$MediaId);
                break;
            case 'voice'      : /*return '������Ϣ';*/
                $MediaId  = '';
                $template = '<xml>
                                <ToUserName><![CDATA[%s]]></ToUserName>
                                <FromUserName><![CDATA[%s]]></FromUserName>
                                <CreateTime>%s</CreateTime>
                                <MsgType><![CDATA[%s]]></MsgType>
                                <Voice>
                                    <MediaId><![CDATA[%s]]></MediaId>
                                </Voice>
                            </xml>';
                $info = sprintf($template,$ToUserName,$FromUserName,$CreateTime,$MsgType,$MediaId);
                break;
            case 'video'      : /*return '��Ƶ��Ϣ';*/
                $MediaId     = '';
                $Title       = '';
                $Description = '';
                $template = '<xml>
                                <ToUserName><![CDATA[%s]]></ToUserName>
                                <FromUserName><![CDATA[%s]]></FromUserName>
                                <CreateTime>%s</CreateTime>
                                <MsgType><![CDATA[%s]]></MsgType>
                                <Video>
                                    <MediaId><![CDATA[%s]]></MediaId>
                                    <Title><![CDATA[%s]]></Title>
                                    <Description><![CDATA[%s]]></Description>
                                </Video>
                            </xml>';
                $info = sprintf($template,$ToUserName,$FromUserName,$CreateTime,$MsgType,$MediaId,$Title,$Description);
                break;
            case 'music'      : /*return '������Ϣ';*/
                $Title        = '';
                $Description  = '';
                $MusicUrl     = '';
                $HQMusicUrl   = '';
                $ThumbMediaId = '';
                $template = '<xml>
                                <ToUserName><![CDATA[%s]]></ToUserName>
                                <FromUserName><![CDATA[%s]]></FromUserName>
                                <CreateTime>%s</CreateTime>
                                <MsgType><![CDATA[%s]]></MsgType>
                                <Music>
                                    <Title><![CDATA[%s]]></Title>
                                    <Description><![CDATA[%s]]></Description>
                                    <MusicUrl><![CDATA[%s]]></MusicUrl>
                                    <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
                                    <ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
                                </Music>
                            </xml>';
                $info = sprintf($template,$ToUserName,$FromUserName,$CreateTime,$MsgType,$Title,$Description,$MusicUrl,$HQMusicUrl,$ThumbMediaId);
            case 'news'       : /*return 'ͼ����Ϣ'(���ݴ�������ݿɷ��Ͷ���ͼ����Ϣ);*/
                $template = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <ArticleCount>".count($array)."</ArticleCount>
                            <Articles>";
                foreach($array as $key=>$value){
                    $template .="<item>
                                <Title><![CDATA[".$value['title']."]]></Title>
                                <Description><![CDATA[".$value['description']."]]></Description>
                                <PicUrl><![CDATA[".$value['picUrl']."]]></PicUrl>
                                <Url><![CDATA[".$value['url']."]]></Url>
                                </item>";
                }
                $template .="</Articles>
                            </xml> ";
                $info = sprintf( $template, $ToUserName, $FromUserName, $CreateTime, $MsgType );
            default           : return 'δ֪��Ϣ���ͣ�����������';
        }
        echo $info;
    }

    /**
     * @FunctionDescription:�ͷ��ӿ�
     * @Description:���û���������Ϣ�����ںŵ�ʱ�򣨰���������Ϣ������Զ���˵��������¼���ɨ���ά���¼���֧���ɹ��¼����û�άȨ����΢�Ž������Ϣ�������͸������ߣ�
     * @Description:��������һ��ʱ���ڣ�Ŀǰ�޸�Ϊ48Сʱ�����Ե��ÿͷ���Ϣ�ӿڣ�ͨ��POSTһ��JSON���ݰ���������Ϣ����ͨ�û�����48Сʱ�ڲ����Ʒ��ʹ�����
     * @Author:helen zheng
     */

    /**
     * @FunctionDescription:��ӿͷ��ʺ�(post)
     * @Param:access_token��custom_service_data(kf_account�������ͷ��˺ţ���ʽΪ���˺�ǰ׺@���ں�΢�ź� ����nickname���ͷ��ǳƣ��6�����ֻ�12��Ӣ���ַ� ����password���ͷ��˺ŵ�¼���룩)
     * @Return:0 ��ok��
     * @Description:ÿ�����ں�������10���ͷ��˺�
     * @Author:helen zheng
     */
    public function customerServiceAccountAdd($access_token,$custom_service_data){
        $url = 'https://api.weixin.qq.com/customservice/kfaccount/add?access_token='.$access_token;
        $result = $this->request_post($url,$custom_service_data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:�޸Ŀͷ��˺ţ�post��
     * @Param:access_token��custom_service_data(kf_account�������ͷ��˺ţ���ʽΪ���˺�ǰ׺@���ں�΢�ź� ����nickname���ͷ��ǳƣ��6�����ֻ�12��Ӣ���ַ� ����password���ͷ��˺ŵ�¼���룩)
     * @Return:0 ��ok��
     * @Description:
     * @Author:helen zheng
     */
    public function customerServiceAccountUpdate($access_token,$custom_service_data){
        $url = 'https://api.weixin.qq.com/customservice/kfaccount/update?access_token='.$access_token;
        $result = $this->request_post($url,$custom_service_data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:ɾ���ͷ��ʺ�(get)
     * @Param:
     * @Return:
     * @Description:
     * @Author:helen zheng
     */
    public function customerServiceAccountDelete($access_token){
        $url = 'https://api.weixin.qq.com/customservice/kfaccount/del?access_token='.$access_token;
        $result = $this->request_get($url);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:���ÿͷ��ʺŵ�ͷ��(post)
     * @Param:access_token,data(kf_account(�ͷ��˺�),img_data(ͼƬ))
     * @Return:0 (ok)
     * @Description:���ñ��ӿ����ϴ�ͼƬ��Ϊ�ͷ���Ա��ͷ��ͷ��ͼƬ�ļ�������jpg��ʽ���Ƽ�ʹ��640*640��С��ͼƬ�Դﵽ���Ч����
     * @Author:helen zheng
     */
    public function customerServiceAccountImg($access_token,$kf_account,$img_data){
        $url = 'http://api.weixin.qq.com/customservice/kfaccount/uploadheadimg?access_token='.$access_token.'&kf_account='.$kf_account;
        $result = $this->request_post($url,$img_data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:��ȡ���пͷ��˺�(get)
     * @Param:access_token
     * @Return:
     * @Description:ͨ�����ӿڣ���ȡ���ں��������õĿͷ�������Ϣ�������ͷ����š��ͷ��ǳơ��ͷ���¼�˺š�
     * @Author:helen zheng
     */
    public function customerServiceAccountList($access_token){
        $url = 'https://api.weixin.qq.com/cgi-bin/customservice/getkflist?access_token='.$access_token;
        $result = $this->request_get($url);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:�ͷ��ӿ�-����Ϣ(post)
     * @Param:access_token��data(touser��msgtype��content��media_id ��thumb_media_id )
     * @Return:
     * @Description:������Ϣ���ͣ��ı���Ϣ��ͼƬ��Ϣ��������Ϣ����Ƶ��Ϣ��������Ϣ��ͼ����Ϣ�������ת������/ͼ����Ϣҳ�� ͼ����Ϣ����������8�����ڣ�ע�⣬���ͼ��������8���򽫻�����Ӧ�� �������Ϳ�ȯ
     * @Author:helen zheng
     */
    public function customerServiceSend($access_token,$data){
        $url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$access_token;
        $result = $this->request_post($url,$data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:�߼�Ⱥ���ӿ�
     * @Description:������֤���ĺţ�Ⱥ���ӿ�ÿ��ɳɹ�����1�Σ��˴�Ⱥ����ѡ���͸�ȫ���û���ĳ�����飻
     * @Description:������֤�������Ȼ������ʹ�ø߼�Ⱥ���ӿڵ�ÿ�յ�������Ϊ100�Σ������û�ÿ��ֻ�ܽ���4���������ڹ���ƽ̨��վ�ϣ�����ʹ�ýӿ�Ⱥ�����û�ÿ��ֻ�ܽ���4��Ⱥ����Ϣ������4����Ⱥ�����Ը��û�����ʧ�ܣ�
     * @Author:helen zheng
     */

    /**
     * @FunctionDescription:�ϴ�ͼ����Ϣ�ڵ�ͼƬ��ȡURL�����ĺ���������֤������á�(post)
     * @Param:  access_token 	�� 	���ýӿ�ƾ֤
                media 	        �� 	form-data��ý���ļ���ʶ����filename��filelength��content-type����Ϣ
     * @Return: url (�ϴ�ͼƬ��URL�������ں���Ⱥ���У����õ�ͼ����Ϣ��)��
     * @Description:���ӿ����ϴ���ͼƬ��ռ�ù��ںŵ��زĿ���ͼƬ������5000�������ơ�ͼƬ��֧��jpg/png��ʽ����С������1MB���¡�
     * @Author:helen zheng
     */
    public function uploadImg($access_token,$img_data){
        $url = 'https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token='.$access_token;
        $result = $this->request_post($url,$img_data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:�ϴ�ͼ����Ϣ�زġ����ĺ���������֤������á�(post)
     * @Param:  Articles 	        �� 	ͼ����Ϣ��һ��ͼ����Ϣ֧��1��8��ͼ��
                thumb_media_id 	    �� 	ͼ����Ϣ����ͼ��media_id�������ڻ���֧��-�ϴ���ý���ļ��ӿ��л��
                author 	            �� 	ͼ����Ϣ������
                title 	            �� 	ͼ����Ϣ�ı���
                content_source_url 	�� 	��ͼ����Ϣҳ�������Ķ�ԭ�ġ����ҳ��
                content 	        �� 	ͼ����Ϣҳ������ݣ�֧��HTML��ǩ���߱�΢��֧��Ȩ�޵Ĺ��ںţ�����ʹ��a��ǩ���������ںŲ���ʹ��
                digest 	            �� 	ͼ����Ϣ������
                show_cover_pic 	    �� 	�Ƿ���ʾ���棬1Ϊ��ʾ��0Ϊ����ʾ
     * @Return: type 	    ý���ļ����ͣ��ֱ���ͼƬ��image����������voice������Ƶ��video��������ͼ��thumb��������Ϊnews����ͼ����Ϣ
                media_id 	ý���ļ�/ͼ����Ϣ�ϴ����ȡ��Ψһ��ʶ
                created_at 	ý���ļ��ϴ�ʱ��
     * @Description:
     * @Author:helen zheng
     */
    public function uploadNews($access_token,$news_data){
        $url = 'https://api.weixin.qq.com/cgi-bin/media/uploadnews?access_token='.$access_token;
        $result = $this->request_post($url,$news_data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:���ݷ������Ⱥ�������ĺ���������֤������á�(post)
     * @Param:  filter 	        �� 	�����趨ͼ����Ϣ�Ľ�����
                is_to_all 	    �� 	�����趨�Ƿ���ȫ���û����ͣ�ֵΪtrue��false��ѡ��true����ϢȺ���������û���ѡ��false�ɸ���group_id���͸�ָ��Ⱥ����û�
                group_id 	    �� 	Ⱥ�����ķ����group_id���μ��û��������û�����ӿڣ���is_to_allֵΪtrue���ɲ���дgroup_id
                mpnews 	        �� 	�����趨�������͵�ͼ����Ϣ
                media_id 	    �� 	����Ⱥ������Ϣ��media_id
                msgtype 	    �� 	Ⱥ������Ϣ���ͣ�ͼ����ϢΪmpnews���ı���ϢΪtext������Ϊvoice������Ϊmusic��ͼƬΪimage����ƵΪvideo����ȯΪwxcard
                title 	        �� 	��Ϣ�ı���
                description 	�� 	��Ϣ������
                thumb_media_id 	�� 	��Ƶ����ͼ��ý��ID
     * @Return: type 	      ý���ļ����ͣ��ֱ���ͼƬ��image����������voice������Ƶ��video��������ͼ��thumb����ͼ����ϢΪnews
                errcode 	  ������
                errmsg 	      ������Ϣ
                msg_id 	      ��Ϣ���������ID
                msg_data_id   ��Ϣ������ID�����ֶ�ֻ����Ⱥ��ͼ����Ϣʱ���Ż���֡�����������ͼ�ķ������ݽӿ��У���ȡ����Ӧ��ͼ����Ϣ�����ݣ���ͼ�ķ������ݽӿ��е�msgid�ֶ��е�ǰ�벿�֣����ͼ�ķ������ݽӿ��е�msgid�ֶεĽ��ܡ�
     * @Description:
     * @Author:helen zheng
     */
    public function sendallByGroups($access_token,$data){
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token='.$access_token;
        $result = $this->request_post($url,$data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:����OpenID�б�Ⱥ�������ĺŲ����ã��������֤����á�(post)
     * @Param:  touser 	        �� 	��дͼ����Ϣ�Ľ����ߣ�һ��OpenID�б�OpenID����2�������10000��
                mpnews 	        �� 	�����趨�������͵�ͼ����Ϣ
                media_id 	    �� 	����Ⱥ����ͼ����Ϣ��media_id
                msgtype 	    �� 	Ⱥ������Ϣ���ͣ�ͼ����ϢΪmpnews���ı���ϢΪtext������Ϊvoice������Ϊmusic��ͼƬΪimage����ƵΪvideo����ȯΪwxcard
                title 	        �� 	��Ϣ�ı���
                description 	�� 	��Ϣ������
                thumb_media_id 	�� 	��Ƶ����ͼ��ý��ID
     * @Return: type 	        ý���ļ����ͣ��ֱ���ͼƬ��image����������voice������Ƶ��video��������ͼ��thumb��������Ϊnews����ͼ����Ϣ
                errcode 	    ������
                errmsg 	        ������Ϣ
                msg_id 	        ��Ϣ���������ID
                msg_data_id 	��Ϣ������ID�������ֶ�ֻ����Ⱥ��ͼ����Ϣʱ���Ż���֡�����������ͼ�ķ������ݽӿ��У���ȡ����Ӧ��ͼ����Ϣ�����ݣ���ͼ�ķ������ݽӿ��е�msgid�ֶ��е�ǰ�벿�֣����ͼ�ķ������ݽӿ��е�msgid�ֶεĽ��ܡ�
     * @Description:
     * @Author:helen zheng
     */
    public function sendallByOpenID($access_token,$data){
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token='.$access_token;
        $result = $this->request_post($url,$data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:ɾ��Ⱥ�������ĺ���������֤������á�(post)
     * @Param: msg_id 	�� 	���ͳ�ȥ����ϢID
     * @Return: 0 (ok)
     * @Description:Ⱥ��ֻ���ڸշ����İ�Сʱ�ڿ���ɾ����������Сʱ֮���޷���ɾ����
     * @Author:helen zheng
     */
    public function sendallDelete($access_token,$msg_id){
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/delete?access_token='.$access_token;
        $result = $this->request_post($url,$msg_id);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:Ԥ���ӿڡ����ĺ���������֤������á�(post)
     * @Param:  touser 	    ������Ϣ�û���Ӧ�ù��ںŵ�openid�����ֶ�Ҳ���Ը�Ϊtowxname����ʵ�ֶ�΢�źŵ�Ԥ��
                msgtype 	Ⱥ������Ϣ���ͣ�ͼ����ϢΪmpnews���ı���ϢΪtext������Ϊvoice������Ϊmusic��ͼƬΪimage����ƵΪvideo����ȯΪwxcard
                media_id 	����Ⱥ������Ϣ��media_id
                content 	�����ı���Ϣʱ�ı�������
     * @Return: msg_id 	    ��ϢID
     * @Description:�����߿�ͨ���ýӿڷ�����Ϣ��ָ���û������ֻ��˲鿴��Ϣ����ʽ���Ű档Ϊ�����������ƽ̨�����ߵ������ڱ�����openIDԤ��������ͬʱ�������˶�ָ��΢�źŷ���Ԥ������������������ÿ�յ��ô��������ƣ�100�Σ����������á�
     * @Author:helen zheng
     */
    public function preview($access_token,$data){
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/preview?access_token='.$access_token;
        $result = $this->request_post($url,$data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:��ѯȺ����Ϣ����״̬�����ĺ���������֤������á�(post)
     * @Param:  msg_id 	    Ⱥ����Ϣ�󷵻ص���Ϣid
     * @Return: msg_id 	    Ⱥ����Ϣ�󷵻ص���Ϣid
                msg_status 	��Ϣ���ͺ��״̬��SEND_SUCCESS��ʾ���ͳɹ�
     * @Description:
     * @Author:helen zheng
     */
    public function sendallStatus($access_token,$msg_id){
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/get?access_token='.$access_token;
        $result = $this->request_post($url,$msg_id);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:ģ����Ϣ�ӿ�(post)
     * @Description:ģ����Ϣ�����ڹ��ں����û�������Ҫ�ķ���֪ͨ��ֻ�����ڷ�����Ҫ��ķ��񳡾���.
     * @Description:ֻ����֤��ķ���Ųſ�������ģ����Ϣ��ʹ��Ȩ�޲���ø�Ȩ�ޣ�
     * @Author:helen zheng
     */

    /**
     * @FunctionDescription:����������ҵ(post)
     * @Param:  industry_id1 	�� 	���ں�ģ����Ϣ������ҵ���
                industry_id2 	�� 	���ں�ģ����Ϣ������ҵ���
     * @Return:
     * @Description:������ҵ����MP����ɣ�ÿ�¿��޸���ҵ1�Σ��˺Ž���ʹ��������ҵ����ص�ģ��
     * @Author:helen zheng
     */
    public function setIndustry($access_token,$data){
        $url = 'https://api.weixin.qq.com/cgi-bin/template/api_set_industry?access_token='.$access_token;
        $result = $this->request_post($url,$data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:���ģ��ID(post)
     * @Param: template_id_short 	�� 	ģ�����ģ��ı�ţ��С�TM**���͡�OPENTMTM**������ʽ
     * @Return:template_id
     * @Description:
     * @Author:helen zheng
     */
    public function getTemplateId($access_token,$template_id_short){
        $url = 'https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token='.$access_token;
        $result = $this->request_post($url,$template_id_short);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:����ģ����Ϣ(post)
     * @Param:
     * @Return: msgid
     * @Description:
     * @Author:helen zheng
     */
    public function sendTemplateMsg($access_token,$data){
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token;
        $result = $this->request_post($url,$data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:��ȡ�Զ��ظ�����(get)
     * @Param:
     * @Return: is_add_friend_reply_open 	    ��ע���Զ��ظ��Ƿ�����0����δ������1������
                is_autoreply_open 	            ��Ϣ�Զ��ظ��Ƿ�����0����δ������1������
                add_friend_autoreply_info 	    ��ע���Զ��ظ�����Ϣ
                type 	                        �Զ��ظ������͡���ע���Զ��ظ�����Ϣ�Զ��ظ������ͽ�֧���ı���text����ͼƬ��img����������voice������Ƶ��video�����ؼ����Զ��ظ��򻹶���ͼ����Ϣ��news��
                content 	                    �����ı����ͣ�content���ı����ݣ�����ͼ�ġ�ͼƬ����������Ƶ���ͣ�content��mediaID
                message_default_autoreply_info 	��Ϣ�Զ��ظ�����Ϣ
                keyword_autoreply_info 	        �ؼ����Զ��ظ�����Ϣ
                rule_name 	                    ��������
                create_time 	                ����ʱ��
                reply_mode 	                    �ظ�ģʽ��reply_all����ȫ���ظ���random_one��������ظ�����һ��
                keyword_list_info 	            ƥ��Ĺؼ����б�
                match_mode 	                    ƥ��ģʽ��contain������Ϣ�к��иùؼ��ʼ��ɣ�equal��ʾ��Ϣ���ݱ���͹ؼ����ϸ���ͬ
                news_info 	                    ͼ����Ϣ����Ϣ
                title 	                        ͼ����Ϣ�ı���
                digest 	                        ժҪ
                author 	                        ����
                show_cover 	                    �Ƿ���ʾ���棬0Ϊ����ʾ��1Ϊ��ʾ
                cover_url 	                    ����ͼƬ��URL
                content_url 	                ���ĵ�URL
                source_url 	                    ԭ�ĵ�URL�����ÿ����޲鿴ԭ�����
     * @Description:�����߿���ͨ���ýӿڣ���ȡ���ںŵ�ǰʹ�õ��Զ��ظ����򣬰�����ע���Զ��ظ�����Ϣ�Զ��ظ���60�����ڴ���һ�Σ����ؼ����Զ��ظ���
     * @Author:helen zheng
     */
    public function getCurrentAutoreplyInfo($access_token){
        $url = 'https://api.weixin.qq.com/cgi-bin/get_current_autoreply_info?access_token='.$access_token;
        $result = $this->request_get($url);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:�زĹ���
     * @Description:�Զ�ý���ļ�����ý����Ϣ�Ļ�ȡ�͵��õȲ�������ͨ��media_id�����еġ�
     * @Description:�زĹ���ӿڶ�������֤�Ķ��ĺźͷ���ſ��ţ�ע���Զ���˵��ӿں��زĹ���ӿ��������ƽ̨����δ��֤���ĺſ��ţ���
     * @Description:ͼƬ��С������2M��֧��bmp/png/jpeg/jpg/gif��ʽ��������С������5M�����Ȳ�����60�룬֧��mp3/wma/wav/amr��ʽ
     * @Author:helen zheng
     */

    /**
     * @FunctionDescription:������ʱ�زģ����ӿڼ�Ϊԭ���ϴ���ý���ļ����ӿڡ�����post��
     * @Param:  access_token 	�� 	���ýӿ�ƾ֤
                type 	        �� 	ý���ļ����ͣ��ֱ���ͼƬ��image����������voice������Ƶ��video��������ͼ��thumb��
                media 	        �� 	form-data��ý���ļ���ʶ����filename��filelength��content-type����Ϣ
     * @Return: type 	    ý���ļ����ͣ��ֱ���ͼƬ��image����������voice������Ƶ��video��������ͼ��thumb����Ҫ������Ƶ�����ָ�ʽ������ͼ��
                media_id 	ý���ļ��ϴ��󣬻�ȡʱ��Ψһ��ʶ
                created_at 	ý���ļ��ϴ�ʱ���
     * @Description:������ʱ�زģ�ÿ���زģ�media_id�����ڿ������ϴ����˿���͵�΢�ŷ�����3����Զ�ɾ����media_id�ǿɸ��õġ�
     * @Description:�ϴ�����ʱ��ý���ļ��и�ʽ�ʹ�С���ƣ����£�
                        ͼƬ��image��: 1M��֧��JPG��ʽ
                        ������voice����2M�����ų��Ȳ�����60s��֧��AMR\MP3��ʽ
                        ��Ƶ��video����10MB��֧��MP4��ʽ
                        ����ͼ��thumb����64KB��֧��JPG��ʽ
     * @Author:helen zheng
     */
    public function mediaUpload($access_token,$type,$data){
        $url = 'https://api.weixin.qq.com/cgi-bin/media/upload?access_token='.$access_token.'&type='.$type;
        $result = $this->request_post($url,$data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:��ȡ��ʱ�ز� (���ӿڼ�Ϊԭ�����ض�ý���ļ����ӿڡ�)(get)
     * @Param:  access_token 	�� 	���ýӿ�ƾ֤
                media_id 	    �� 	ý���ļ�ID
     * @Return:
     * @Description:ʹ�ñ��ӿڻ�ȡ��ʱ�زģ���������ʱ�Ķ�ý���ļ�������ע�⣬��Ƶ�ļ���֧��https���أ����øýӿ���httpЭ�顣
     * @Author:helen zheng
     */
    public function mediaGet($access_token,$media_id){
        $url = 'https://api.weixin.qq.com/cgi-bin/media/get?access_token='.$access_token.'&media_id='.$media_id;
        $result = $this->request_get($url);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:��������ͼ���ز�(post)
     * @Param:  title 	            �� 	����
                thumb_media_id 	    �� 	ͼ����Ϣ�ķ���ͼƬ�ز�id������������mediaID��
                author 	            �� 	����
                digest 	            �� 	ͼ����Ϣ��ժҪ�����е�ͼ����Ϣ����ժҪ����ͼ�Ĵ˴�Ϊ��
                show_cover_pic 	    �� 	�Ƿ���ʾ���棬0Ϊfalse��������ʾ��1Ϊtrue������ʾ
                content 	        �� 	ͼ����Ϣ�ľ������ݣ�֧��HTML��ǩ����������2���ַ���С��1M���Ҵ˴���ȥ��JS
                content_source_url 	�� 	ͼ����Ϣ��ԭ�ĵ�ַ����������Ķ�ԭ�ġ����URL
     * @Return: media_id ���صļ�Ϊ������ͼ����Ϣ�زĵ�media_id��
     * @Description:�����زĵ������������޵ģ������������ͼ����Ϣ�زĺ�ͼƬ�زĵ�����Ϊ5000����������Ϊ1000.�زĵĸ�ʽ��С��Ҫ���빫��ƽ̨����һ�¡�
     * @Author:helen zheng
     */
    public function addPermanentGraphicMaterial($access_token,$news_data){
        $url = 'https://api.weixin.qq.com/cgi-bin/material/add_news?access_token='.$access_token;
        $result = $this->request_post($url,$news_data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:�����������������ز�(post)
     * @Param:  access_token 	�� 	���ýӿ�ƾ֤
                type 	        �� 	ý���ļ����ͣ��ֱ���ͼƬ��image����������voice������Ƶ��video��������ͼ��thumb��
                media 	        �� 	form-data��ý���ļ���ʶ����filename��filelength��content-type����Ϣ
     * @Return:
     * @Description:ͨ��POST�������ýӿڣ���idΪmedia��������Ҫ�ϴ����ز����ݣ���filename��filelength��content-type����Ϣ��
     * @Description:��ע�⣺ͼƬ�زĽ����빫��ƽ̨�����زĹ���ģ���е�Ĭ�Ϸ��顣
     * @Author:helen zheng
     */
    public function addPermanentOtherMaterial($access_token,$data){
        $url = 'https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=ACCESS_TOKEN';
        $result = $this->request_post($url,$data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:��ȡ�����ز�(post)
     * @Param:  access_token 	�� 	���ýӿ�ƾ֤
                media_id 	    �� 	Ҫ��ȡ���زĵ�media_id
     * @Return: title 	            ͼ����Ϣ�ı���
                thumb_media_id 	    ͼ����Ϣ�ķ���ͼƬ�ز�id������������mediaID��
                show_cover_pic 	    �Ƿ���ʾ���棬0Ϊfalse��������ʾ��1Ϊtrue������ʾ
                author 	            ����
                digest 	            ͼ����Ϣ��ժҪ�����е�ͼ����Ϣ����ժҪ����ͼ�Ĵ˴�Ϊ��
                content 	        ͼ����Ϣ�ľ������ݣ�֧��HTML��ǩ����������2���ַ���С��1M���Ҵ˴���ȥ��JS
                url 	            ͼ��ҳ��URL
                content_source_url 	ͼ����Ϣ��ԭ�ĵ�ַ����������Ķ�ԭ�ġ����URL
     * @Description:
     * @Author:helen zheng
     */
    public function getPermanentMaterial($access_token,$media_id){
        $url = 'https://api.weixin.qq.com/cgi-bin/material/get_material?access_token='.$access_token;
        $result = $this->request_post($url,$media_id);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:ɾ�������ز�(post)
     * @Param:  access_token 	�� 	���ýӿ�ƾ֤
                media_id 	    �� 	Ҫ��ȡ���زĵ�media_id
     * @Return:
     * @Description:
     * @Author:helen zheng
     */
    public function deletePermanentMaterial($access_token,$media_id){
        $url = 'https://api.weixin.qq.com/cgi-bin/material/del_material?access_token='.$access_token;
        $result = $this->request_post($url,$media_id);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:�޸�����ͼ���ز�(post)
     * @Param:  media_id 	        �� 	Ҫ�޸ĵ�ͼ����Ϣ��id
                index 	            �� 	Ҫ���µ�������ͼ����Ϣ�е�λ�ã���ͼ����Ϣʱ�����ֶβ������壩����һƪΪ0
                title 	            �� 	����
                thumb_media_id 	    �� 	ͼ����Ϣ�ķ���ͼƬ�ز�id������������mediaID��
                author 	            �� 	����
                digest 	            �� 	ͼ����Ϣ��ժҪ�����е�ͼ����Ϣ����ժҪ����ͼ�Ĵ˴�Ϊ��
                show_cover_pic 	    �� 	�Ƿ���ʾ���棬0Ϊfalse��������ʾ��1Ϊtrue������ʾ
                content 	        �� 	ͼ����Ϣ�ľ������ݣ�֧��HTML��ǩ����������2���ַ���С��1M���Ҵ˴���ȥ��JS
                content_source_url 	�� 	ͼ����Ϣ��ԭ�ĵ�ַ����������Ķ�ԭ�ġ����URL
     * @Return: 0 (ok)
     * @Description:
     * @Author:helen zheng
     */
    public function updatePermanentGraphicMaterial($access_token,$news_data){
        $url = 'https://api.weixin.qq.com/cgi-bin/material/update_news?access_token='.$access_token;
        $result = $this->request_post($url,$news_data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:��ȡ�ز�����(get)
     * @Param:
     * @Return: voice_count 	����������
                video_count 	��Ƶ������
                image_count 	ͼƬ������
                news_count 	    ͼ��������
     * @Description:�����߿��Ը��ݱ��ӿ�����ȡ�����زĵ��б�.1.�����زĵ�������Ҳ����㹫��ƽ̨�����زĹ����е��ز�
                    2.ͼƬ��ͼ����Ϣ�زģ�������ͼ�ĺͶ�ͼ�ģ�����������Ϊ5000�������زĵ���������Ϊ1000
                    3.���øýӿ���httpsЭ��
     * @Author:helen zheng
     */
    public function getPermanentMaterialCount($access_token){
        $url = 'https://api.weixin.qq.com/cgi-bin/material/get_materialcount?access_token='.$access_token;
        $result = $this->request_get($url);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:��ȡ�ز��б�
     * @Param:  type 	�� 	�زĵ����ͣ�ͼƬ��image������Ƶ��video�������� ��voice����ͼ�ģ�news��
                offset 	�� 	��ȫ���زĵĸ�ƫ��λ�ÿ�ʼ���أ�0��ʾ�ӵ�һ���ز� ����
                count 	�� 	�����زĵ�������ȡֵ��1��20֮��
     * @Return: total_count 	    �����͵��زĵ�����
                item_count 	        ���ε��û�ȡ���زĵ�����
                title 	            ͼ����Ϣ�ı���
                thumb_media_id 	    ͼ����Ϣ�ķ���ͼƬ�ز�id������������mediaID��
                show_cover_pic 	    �Ƿ���ʾ���棬0Ϊfalse��������ʾ��1Ϊtrue������ʾ
                author 	            ����
                digest 	            ͼ����Ϣ��ժҪ�����е�ͼ����Ϣ����ժҪ����ͼ�Ĵ˴�Ϊ��
                content 	        ͼ����Ϣ�ľ������ݣ�֧��HTML��ǩ����������2���ַ���С��1M���Ҵ˴���ȥ��JS
                url 	            ͼ��ҳ��URL�����ߣ�����ȡ���б���ͼƬ�ز��б�ʱ�����ֶ���ͼƬ��URL
                content_source_url 	ͼ����Ϣ��ԭ�ĵ�ַ����������Ķ�ԭ�ġ����URL
                update_time 	    ��ƪͼ����Ϣ�زĵ�������ʱ��
                name 	            �ļ�����
     * @Description:�����߿��Է����ͻ�ȡ�����زĵ��б�
     * @Author:helen zheng
     */
    public function getPermanentMaterialList($access_token,$data){
        $url = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token='.$access_token;
        $result = $this->request_post($url,$data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:�û�����
     * @Description:�����߿���ʹ�ýӿڣ��Թ���ƽ̨�ķ�����в�ѯ���������޸ġ�ɾ���Ȳ�����Ҳ����ʹ�ýӿ�����Ҫʱ�ƶ��û���ĳ�����顣
     * @Author:helen zheng
     */

    /**
     * @FunctionDescription:��������(post)
     * @Param:  access_token 	���ýӿ�ƾ֤
                name 	        �������֣�30���ַ����ڣ�
     * @Return: id 	            ����id����΢�ŷ���
                name 	        �������֣�UTF8����
     * @Description:һ�������˺ţ����֧�ִ���100�����顣
     * @Author:helen zheng
     */
    public function createGroups($access_token,$group_data){
        $url = 'https://api.weixin.qq.com/cgi-bin/groups/create?access_token='.$access_token;
        $result = $this->request_post($url,$group_data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:��ѯ���з���(get)
     * @Param:  access_token 	���ýӿ�ƾ֤
     * @Return: groups 	        ����ƽ̨������Ϣ�б�
                id 	            ����id����΢�ŷ���
                name 	        �������֣�UTF8����
                count 	        �������û�����
     * @Description:
     * @Author:helen zheng
     */
    public function getGroups($access_token){
        $url = 'https://api.weixin.qq.com/cgi-bin/groups/get?access_token='.$access_token;
        $result = $this->request_get($url);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:��ѯ�û����ڷ���(post)
     * @Param:  access_token 	���ýӿ�ƾ֤
                openid 	        �û���OpenID
     * @Return: groupid 	    �û�������groupid
     * @Description:
     * @Author:helen zheng
     */
    public function getGroupId($access_token,$openid){
        $url = 'https://api.weixin.qq.com/cgi-bin/groups/getid?access_token='.$access_token;
        $result = $this->request_post($url,$openid);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:�޸ķ�����(post)
     * @Param:  access_token 	���ýӿ�ƾ֤
                id 	            ����id����΢�ŷ���
                name 	        �������֣�30���ַ����ڣ�
     * @Return:
     * @Description:
     * @Author:helen zheng
     */
    public function updateGroupsName($access_token,$group_data){
        $url = 'https://api.weixin.qq.com/cgi-bin/groups/update?access_token='.$access_token;
        $result = $this->request_post($url,$group_data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:�ƶ��û�����(post)
     * @Param:  access_token 	���ýӿ�ƾ֤
                openid 	        �û�Ψһ��ʶ��
                to_groupid 	    ����id
     * @Return:
     * @Description:
     * @Author:helen zheng
     */
    public function updateGroupsUser($access_token,$user_data){
        $url = 'https://api.weixin.qq.com/cgi-bin/groups/members/update?access_token='.$access_token;
        $result = $this->request_post($url,$user_data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:�����ƶ��û�����(post)
     * @Param:  access_token 	���ýӿ�ƾ֤
                openid_list 	�û�Ψһ��ʶ��openid���б�size���ܳ���50��
                to_groupid 	    ����id
     * @Return:
     * @Description:
     * @Author:helen zheng
     */
    public function batchupdateGroupsUser($access_token,$user_data){
        $url = 'https://api.weixin.qq.com/cgi-bin/groups/members/batchupdate?access_token='.$access_token;
        $result = $this->request_post($url,$user_data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:ɾ������(post)
     * @Param:  access_token 	���ýӿ�ƾ֤
                group 	        ����
                id 	            �����id
     * @Return:
     * @Description:���ӿ���ɾ��һ���û����飬ɾ����������и÷����ڵ��û��Զ�����Ĭ�Ϸ��顣
     * @Author:helen zheng
     */
    public function deleteGroups($access_token,$group_data){
        $url = 'https://api.weixin.qq.com/cgi-bin/groups/delete?access_token='.$access_token;
        $result = $this->request_post($url,$group_data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:�����û���ע��(post)
     * @Param:  access_token 	���ýӿ�ƾ֤
                openid 	        �û���ʶ
                remark 	        �µı�ע�������ȱ���С��30�ַ�
     * @Return:
     * @Description:�����߿���ͨ���ýӿڶ�ָ���û����ñ�ע�����ýӿ���ʱ���Ÿ�΢����֤�ķ���š�
     * @Author:helen zheng
     */
    public function updateUserRemark($access_token,$user_data){
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info/updateremark?access_token='.$access_token;
        $result = $this->request_post($url,$user_data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:��ȡ�û�������Ϣ������UnionID���ƣ�(get)
     * @Param:  access_token 	�� 	���ýӿ�ƾ֤
                openid 	        �� 	��ͨ�û��ı�ʶ���Ե�ǰ���ں�Ψһ
                lang 	        �� 	���ع��ҵ������԰汾��zh_CN ���壬zh_TW ���壬en Ӣ��
     * @Return: subscribe 	    �û��Ƿ��ĸù��ںű�ʶ��ֵΪ0ʱ��������û�û�й�ע�ù��ںţ���ȡ����������Ϣ��
                openid 	        �û��ı�ʶ���Ե�ǰ���ں�Ψһ
                nickname 	    �û����ǳ�
                sex 	        �û����Ա�ֵΪ1ʱ�����ԣ�ֵΪ2ʱ��Ů�ԣ�ֵΪ0ʱ��δ֪
                city 	        �û����ڳ���
                country 	    �û����ڹ���
                province 	    �û�����ʡ��
                language 	    �û������ԣ���������Ϊzh_CN
                headimgurl 	    �û�ͷ�����һ����ֵ����������ͷ���С����0��46��64��96��132��ֵ��ѡ��0����640*640������ͷ�񣩣��û�û��ͷ��ʱ����Ϊ�ա����û�����ͷ��ԭ��ͷ��URL��ʧЧ��
                subscribe_time 	�û���עʱ�䣬Ϊʱ���������û�����ι�ע����ȡ����עʱ��
                unionid 	    ֻ�����û������ںŰ󶨵�΢�ſ���ƽ̨�ʺź󣬲Ż���ָ��ֶΡ��������ȡ�û�������Ϣ��UnionID���ƣ�
                remark 	        ���ں���Ӫ�߶Է�˿�ı�ע�����ں���Ӫ�߿���΢�Ź���ƽ̨�û��������Է�˿��ӱ�ע
                groupid 	    �û����ڵķ���ID
     * @Description:�ڹ�ע���빫�ںŲ�����Ϣ�����󣬹��ںſɻ�ù�ע�ߵ�OpenID�����ܺ��΢�źţ�ÿ���û���ÿ�����ںŵ�OpenID��Ψһ�ġ����ڲ�ͬ���ںţ�ͬһ�û���openid��ͬ����
     * @Description:���ںſ�ͨ�����ӿ�������OpenID��ȡ�û�������Ϣ�������ǳơ�ͷ���Ա����ڳ��С����Ժ͹�עʱ�䡣
     * @Description:������������ڶ�����ںţ����ڹ��ںš��ƶ�Ӧ��֮��ͳһ�û��ʺŵ�������Ҫǰ��΢�ſ���ƽ̨��open.weixin.qq.com���󶨹��ںź󣬲ſ�����UnionID������������������
     * @Author:helen zheng
     */
    public function getUserInfo($access_token,$openid){
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
        $result = $this->request_get($url);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:������ȡ�û�������Ϣ(post)
     * @Param:  openid 	�� 	�û��ı�ʶ���Ե�ǰ���ں�Ψһ
     * @Return: ͬ��
     * @Description:�����߿�ͨ���ýӿ���������ȡ�û�������Ϣ�����֧��һ����ȡ100����
     * @Author:helen zheng
     */
    public function batchgetUserInfo($access_token,$user_list){
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info/batchget?access_token='.$access_token;
        $result = $this->request_post($url,$user_list);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:��ȡ�û��б�(get)
     * @Param:  access_token 	�� 	���ýӿ�ƾ֤
                next_openid 	�� 	��һ����ȡ��OPENID������Ĭ�ϴ�ͷ��ʼ��ȡ
     * @Return: total 	        ��ע�ù����˺ŵ����û���
                count 	        ��ȡ��OPENID���������ֵΪ10000
                data 	        �б����ݣ�OPENID���б�
                next_openid 	��ȡ�б�����һ���û���OPENID
     * @Description:���ںſ�ͨ�����ӿ�����ȡ�ʺŵĹ�ע���б���ע���б���һ��OpenID�����ܺ��΢�źţ�ÿ���û���ÿ�����ںŵ�OpenID��Ψһ�ģ���ɡ�
     * @Description:һ����ȡ���������ȡ10000����ע�ߵ�OpenID������ͨ�������ȡ�ķ�ʽ����������
     * @Author:helen zheng
     */
    public function getUserList($access_token,$next_openid=null){
        $url = 'https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$access_token.'&next_openid='.$next_openid;
        $result = $this->request_get($url);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:�Զ���˵��ӿ�
     * @Description:�Զ���˵�������3��һ���˵���ÿ��һ���˵�������5�������˵���һ���˵����4�����֣������˵����7������.
     * @Description:�����Զ���˵�������΢�ſͻ��˻��棬��Ҫ24Сʱ΢�ſͻ��˲Ż�չ�ֳ���
     * @Author:helen zheng
     */

    /**
     * @FunctionDescription:�Զ���˵������ӿڣ�post��
     * @Param:menu_data( button(һ���˵�����)��sub_button[�����˵�����]��type(�˵�����Ӧ�������� )��name (�˵����⣬������16���ֽڣ��Ӳ˵�������40���ֽ� ) )
     * @Param:menu_data(key (click�ȵ�����ͱ��� ���˵�KEYֵ��������Ϣ�ӿ����ͣ�������128�ֽ� )��url(view���ͱ��� ��ҳ���ӣ��û�����˵��ɴ����ӣ�������256�ֽ� )��media_id (media_id���ͺ�view_limited���ͱ��� �������������زĽӿڷ��صĺϷ�media_id ) )
     * @Return:0 ��ok��
     * @Description:��ť���ͣ�click��������¼�;view����תURL;scancode_push��ɨ�����¼�;scancode_waitmsg��ɨ�����¼��ҵ�������Ϣ�����С���ʾ��;pic_sysphoto������ϵͳ���շ�ͼ
     * @Description:��ť���ͣ�pic_photo_or_album���������ջ�����ᷢͼ;pic_weixin������΢����ᷢͼ��;location_select����������λ��ѡ����;media_id���·���Ϣ�����ı���Ϣ��;view_limited����תͼ����ϢURL
     * @Author:helen zheng
     */
    public function customMenuEdit($menu_data,$access_token){
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$access_token;
        $result = $this->request_post($url,$menu_data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:�Զ���˵���ѯ�ӿڣ�get��
     * @Param:access_token
     * @Return:�Զ���˵���Ϣ
     * @Description:��ѯ�Զ���˵��Ľṹ��
     * @Author:helen zheng
     */
    public function customMenuSearch($access_token){
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/get?access_token='.$access_token;
        $result = $this->request_get($url);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:�Զ���˵�ɾ���ӿڣ�get��
     * @Param:access_token
     * @Return:0 ��ok��
     * @Description:ɾ����ǰʹ�õ��Զ���˵���
     * @Author:helen zheng
     */
    public function customMenuDelete($access_token){
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/delete?access_token='.$access_token;
        $result = $this->request_get($url);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:��ȡ�Զ���˵����ýӿ�(get)
     * @Param:access_token
     * @Return:is_menu_open(�˵��Ƿ�����0����δ������1������ )��selfmenu_info(�˵���Ϣ )��button (�˵���ť )��type (�˵�������)��name (�˵����� )��value��url��key���ֶ�
     * @Return:news_info(ͼ����Ϣ����Ϣ )��title(ͼ����Ϣ�ı��� )��digest(ժҪ )��author (����)��show_cover (�Ƿ���ʾ���棬0Ϊ����ʾ��1Ϊ��ʾ )��cover_url( ����ͼƬ��URL )��content_url( ���ĵ�URL )��source_url�� ԭ�ĵ�URL�����ÿ����޲鿴ԭ����ڣ�
     * @Description:���ӿڽ����ṩ���ںŵ�ǰʹ�õ��Զ���˵������ã�������ں���ͨ��API�������õĲ˵����򷵻ز˵��Ŀ������ã���������ں����ڹ���ƽ̨����ͨ����վ���ܷ����˵����򱾽ӿڷ�����Ӫ�����õĲ˵����á�
     * @Author:helen zheng
     */
    public function customMenuList($access_token){
        $url = 'https://api.weixin.qq.com/cgi-bin/get_current_selfmenu_info?access_token='.$access_token;
        $result = $this->request_get($url);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:�˺Ź���
     * @Description:���ɴ������Ķ�ά�롢������ת�����ӽӿڡ�΢����֤�¼�����
     * @Author:helen zheng
     */

    /**
     * @FunctionDescription:������ά��ticket
     * @Param:  expire_seconds 	�ö�ά����Чʱ�䣬����Ϊ��λ�� ��󲻳���2592000����30�죩�����ֶ���������Ĭ����Ч��Ϊ30�롣
                action_name 	��ά�����ͣ�QR_SCENEΪ��ʱ,QR_LIMIT_SCENEΪ����,QR_LIMIT_STR_SCENEΪ���õ��ַ�������ֵ
                action_info 	��ά����ϸ��Ϣ
                scene_id 	    ����ֵID����ʱ��ά��ʱΪ32λ��0���ͣ����ö�ά��ʱ���ֵΪ100000��Ŀǰ����ֻ֧��1--100000��
                scene_str 	    ����ֵID���ַ�����ʽ��ID�����ַ������ͣ���������Ϊ1��64�������ö�ά��֧�ִ��ֶ�
     * @Return: ticket 	        ��ȡ�Ķ�ά��ticket��ƾ���ticket��������Чʱ���ڻ�ȡ��ά�롣
                expire_seconds 	�ö�ά����Чʱ�䣬����Ϊ��λ�� ��󲻳���2592000����30�죩��
                url 	        ��ά��ͼƬ������ĵ�ַ�������߿ɸ��ݸõ�ַ����������Ҫ�Ķ�ά��ͼƬ
     * @Description:
     * @Author:helen zheng
     */
    public function createQrcodeTicket($access_token,$qrcode_data){
        $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$access_token;
        $result = $this->request_post($url,$qrcode_data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:ͨ��ticket��ȡ��ά��
     * @Param:ticket
     * @Return:
     * @Description:��ȡ��ά��ticket�󣬿����߿���ticket��ȡ��ά��ͼƬ��TICKET�ǵý���UrlEncode
     * @Author:helen zheng
     */
    public function getQrcode($ticket){
        $url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$ticket;
        $result = $this->downloadFile($url);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:������ת�����ӽӿڣ�post��
     * @Param:  access_token 	�� 	���ýӿ�ƾ֤
                action 	        �� 	�˴���long2short����������ת������
                long_url 	    �� 	��Ҫת���ĳ����ӣ�֧��http://��https://��weixin://wxpay ��ʽ��url
     * @Return: short_url 	    �����ӡ�
     * @Description:��һ��������ת�ɶ����ӡ���Ҫʹ�ó����� �������������ɶ�ά���ԭ���ӣ���Ʒ��֧����ά��ȣ�̫������ɨ���ٶȺͳɹ����½�����ԭ������ͨ���˽ӿ�ת�ɶ����������ɶ�ά�뽫�������ɨ���ٶȺͳɹ��ʡ�
     * @Description:
     * @Author:helen zheng
     */
    public function shortUrl($access_token,$data){
        $url = 'https://api.weixin.qq.com/cgi-bin/shorturl?access_token='.$access_token;
        $result = $this->request_post($url,$data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:����ͳ��
     * @Description:�û��������ݽӿڡ�ͼ�ķ������ݽӿڡ���Ϣ�������ݽӿڡ��ӿڷ������ݽӿ�
     * @Author:helen zheng
     */

    /**
     * @FunctionDescription:��ȡ�û���������(post)
     * @Param:  access_token 	�� 	���ýӿ�ƾ֤
                begin_date 	    �� 	��ȡ���ݵ���ʼ���ڣ�begin_date��end_date�Ĳ�ֵ��С�ڡ����ʱ���ȡ����������ʱ����Ϊ1ʱ��begin_date��end_date�Ĳ�ֵֻ��Ϊ0������С��1��������ᱨ��
                end_date 	    �� 	��ȡ���ݵĽ������ڣ�end_date�������õ����ֵΪ����
     * @Return: ref_date 	    ���ݵ�����
                user_source 	�û�����������ֵ����ĺ������£�0����������������������ά�룩 3����ɨ��ά�� 17������Ƭ���� 35�����Ѻ��루��΢���������ҳ�������� 39�����ѯ΢�Ź����ʺ� 43����ͼ��ҳ���Ͻǲ˵�
                new_user 	    �������û�����
                cancel_user 	ȡ����ע���û�������new_user��ȥcancel_user��Ϊ�����û�����
                cumulate_user 	���û���
     * @Description:���ʱ���ȣ�7��
     * @Author:helen zheng
     */
    public function getUserSummary($access_token,$begin_date,$end_date){
        $url = 'https://api.weixin.qq.com/datacube/getusersummary?access_token='.$access_token;
        $data = array(
            "begin_date"=>$begin_date,
            "end_date"=>$end_date
        );
        $data = json_encode($data);
        $result = $this->request_post($url,$data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:��ȡ�ۼ��û�����(post)
     * @Param:ͬ��
     * @Return:ͬ��
     * @Description:���ʱ���ȣ�7��
     * @Author:helen zheng
     */
    public function getUserCumulate($access_token,$begin_date,$end_date){
        $url = 'https://api.weixin.qq.com/datacube/getusercumulate?access_token='.$access_token;
        $data = array(
            "begin_date"=>$begin_date,
            "end_date"=>$end_date
        );
        $data = json_encode($data);
        $result = $this->request_post($url,$data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:��ȡͼ��Ⱥ��ÿ������(post)
     * @Param:  access_token 	�� 	���ýӿ�ƾ֤
                begin_date 	    �� 	��ȡ���ݵ���ʼ���ڣ�begin_date��end_date�Ĳ�ֵ��С�ڡ����ʱ���ȡ����������ʱ����Ϊ1ʱ��begin_date��end_date�Ĳ�ֵֻ��Ϊ0������С��1��������ᱨ��
                end_date 	    �� 	��ȡ���ݵĽ������ڣ�end_date�������õ����ֵΪ����
     * @Return: ref_date 	        ���ݵ����ڣ�����begin_date��end_date֮��
                ref_hour 	        ���ݵ�Сʱ��������000��2300���ֱ�������[000,100)��[2300,2400)����ÿ�յĵ�1Сʱ�����1Сʱ
                stat_date 	        ͳ�Ƶ����ڣ���getarticletotal�ӿ��У�ref_dateָ��������Ⱥ�������ڣ� ��stat_date������ͳ������
                msgid 	            ��ע�⣺�����msgidʵ��������msgid��ͼ����Ϣid����Ҳ����Ⱥ���ӿڵ��ú󷵻ص�msg_data_id����index����Ϣ������������ɣ� ����12003_3�� ����12003��msgid����һ��Ⱥ������Ϣ��id�� 3Ϊindex������ô�Ⱥ����ͼ����Ϣ��5�����£���Ϊ����Ϊ��ͼ�ģ���3��ʾ5���еĵ�3��
                title 	            ͼ����Ϣ�ı���
                int_page_read_user 	ͼ��ҳ�����Ⱥ��ͼ�Ŀ�Ƭ�����ҳ�棩���Ķ�����
                int_page_read_count ͼ��ҳ���Ķ�����
                ori_page_read_user 	ԭ��ҳ�����ͼ��ҳ���Ķ�ԭ�ġ������ҳ�棩���Ķ���������ԭ��ҳʱ�˴�����Ϊ0
                ori_page_read_count ԭ��ҳ���Ķ�����
                share_scene 	    ����ĳ���   1�������ת�� 2��������Ȧ 3������Ѷ΢�� 255��������
                share_user 	        ���������
                share_count 	    ����Ĵ���
                add_to_fav_user 	�ղص�����
                add_to_fav_count 	�ղصĴ���
                target_user 	    �ʹ�������һ��Լ�����ܷ�˿�������ų��������������쳣������޷��յ���Ϣ�ķ�˿��
                user_source 	    �ڻ�ȡͼ���Ķ���ʱ����ʱ���и��ֶΣ������û�������������Ķ���ͼ�ġ�0:�Ự;1.����;2.����Ȧ;3.��Ѷ΢��;4.��ʷ��Ϣҳ;5.����
     * @Description:���ʱ����(1)
     * @Author:helen zheng
     */
    public function getArticleSummary($access_token,$begin_date,$end_date){
        $url = 'https://api.weixin.qq.com/datacube/getarticlesummary?access_token='.$access_token;
        $data = array(
            "begin_date"=>$begin_date,
            "end_date"=>$end_date
        );
        $data = json_encode($data);
        $result = $this->request_post($url,$data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:��ȡͼ��Ⱥ��������(post)
     * @Param:ͬ��
     * @Return:ͬ��
     * @Description:���ʱ����(1)
     * @Author:helen zheng
     */
    public function getArticleTotal($access_token,$begin_date,$end_date){
        $url = 'https://api.weixin.qq.com/datacube/getarticletotal?access_token='.$access_token;
        $data = array(
            "begin_date"=>$begin_date,
            "end_date"=>$end_date
        );
        $data = json_encode($data);
        $result = $this->request_post($url,$data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:��ȡͼ��ͳ������(post)
     * @Param:ͬ��
     * @Return:ͬ��
     * @Description:���ʱ����(3)
     * @Author:helen zheng
     */
    public function getUserRead($access_token,$begin_date,$end_date){
        $url = 'https://api.weixin.qq.com/datacube/getuserread?access_token='.$access_token;
        $data = array(
            "begin_date"=>$begin_date,
            "end_date"=>$end_date
        );
        $data = json_encode($data);
        $result = $this->request_post($url,$data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:��ȡͼ��ͳ�Ʒ�ʱ����(post)
     * @Param:ͬ��
     * @Return:ͬ��
     * @Description:���ʱ����(1)
     * @Author:helen zheng
     */
    public function getUserReadHour($access_token,$begin_date,$end_date){
        $url = 'https://api.weixin.qq.com/datacube/getuserreadhour?access_token='.$access_token;
        $data = array(
            "begin_date"=>$begin_date,
            "end_date"=>$end_date
        );
        $data = json_encode($data);
        $result = $this->request_post($url,$data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:��ȡͼ�ķ���ת������(post)
     * @Param:ͬ��
     * @Return:ͬ��
     * @Description:���ʱ����(7)
     * @Author:helen zheng
     */
    public function getUserShare($access_token,$begin_date,$end_date){
        $url = 'https://api.weixin.qq.com/datacube/getusershare?access_token='.$access_token;
        $data = array(
            "begin_date"=>$begin_date,
            "end_date"=>$end_date
        );
        $data = json_encode($data);
        $result = $this->request_post($url,$data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:��ȡͼ�ķ���ת����ʱ����(post)
     * @Param:ͬ��
     * @Return:ͬ��
     * @Description:���ʱ����(1)
     * @Author:helen zheng
     */
    public function getUserShareHour($access_token,$begin_date,$end_date){
        $url = 'https://api.weixin.qq.com/datacube/getusersharehour?access_token='.$access_token;
        $data = array(
            "begin_date"=>$begin_date,
            "end_date"=>$end_date
        );
        $data = json_encode($data);
        $result = $this->request_post($url,$data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:��ȡ��Ϣ���͸ſ�����(post)
     * @Param:  access_token 	�� 	���ýӿ�ƾ֤
                begin_date 	    �� 	��ȡ���ݵ���ʼ���ڣ�begin_date��end_date�Ĳ�ֵ��С�ڡ����ʱ���ȡ����������ʱ����Ϊ1ʱ��begin_date��end_date�Ĳ�ֵֻ��Ϊ0������С��1��������ᱨ��
                end_date 	    �� 	��ȡ���ݵĽ������ڣ�end_date�������õ����ֵΪ����
     * @Return: ref_date 	        ���ݵ����ڣ�����begin_date��end_date֮��
                ref_hour 	        ���ݵ�Сʱ��������000��2300���ֱ�������[000,100)��[2300,2400)����ÿ�յĵ�1Сʱ�����1Сʱ
                msg_type 	        ��Ϣ���ͣ����������£�1�������� 2����ͼƬ 3�������� 4������Ƶ 6���������Ӧ����Ϣ��������Ϣ��
                msg_user 	        ���з����ˣ����ںŷ����ˣ���Ϣ���û���
                msg_count 	        ���з�������Ϣ����Ϣ����
                count_interval 	    ���շ�����Ϣ���ֲ������䣬0���� ��0����1����1-5����2����6-10����3����10�����ϡ�
                int_page_read_count ͼ��ҳ���Ķ�����
                ori_page_read_user 	ԭ��ҳ�����ͼ��ҳ���Ķ�ԭ�ġ������ҳ�棩���Ķ���������ԭ��ҳʱ�˴�����Ϊ0
     * @Description:���ʱ����(7)
     * @Author:helen zheng
     */
    public function getUpStreamMsg($access_token,$begin_date,$end_date){
        $url = 'https://api.weixin.qq.com/datacube/getupstreammsg?access_token='.$access_token;
        $data = array(
            "begin_date"=>$begin_date,
            "end_date"=>$end_date
        );
        $data = json_encode($data);
        $result = $this->request_post($url,$data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:��ȡ��Ϣ���ͷ�ʱ����(post)
     * @Param:ͬ��
     * @Return:ͬ��
     * @Description:���ʱ����(1)
     * @Author:helen zheng
     */
    public function getUpstreamMsgHour($access_token,$begin_date,$end_date){
        $url = 'https://api.weixin.qq.com/datacube/getupstreammsghour?access_token='.$access_token;
        $data = array(
            "begin_date"=>$begin_date,
            "end_date"=>$end_date
        );
        $data = json_encode($data);
        $result = $this->request_post($url,$data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:��ȡ��Ϣ����������(post)
     * @Param:ͬ��
     * @Return:ͬ��
     * @Description:���ʱ����(30)
     * @Author:helen zheng
     */
    public function getUpstreamMsgWeek($access_token,$begin_date,$end_date){
        $url = 'https://api.weixin.qq.com/datacube/getupstreammsgweek?access_token='.$access_token;
        $data = array(
            "begin_date"=>$begin_date,
            "end_date"=>$end_date
        );
        $data = json_encode($data);
        $result = $this->request_post($url,$data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:��ȡ��Ϣ����������(post)
     * @Param:ͬ��
     * @Return:ͬ��
     * @Description:���ʱ����(30)
     * @Author:helen zheng
     */
    public function getUpstreamMsgMonth($access_token,$begin_date,$end_date){
        $url = 'https://api.weixin.qq.com/datacube/getupstreammsgmonth?access_token='.$access_token;
        $data = array(
            "begin_date"=>$begin_date,
            "end_date"=>$end_date
        );
        $data = json_encode($data);
        $result = $this->request_post($url,$data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:��ȡ��Ϣ���ͷֲ�����(post)
     * @Param:ͬ��
     * @Return:ͬ��
     * @Description:���ʱ����(15)
     * @Author:helen zheng
     */
    public function getUpstreamMsgDist($access_token,$begin_date,$end_date){
        $url = 'https://api.weixin.qq.com/datacube/getupstreammsgdist?access_token='.$access_token;
        $data = array(
            "begin_date"=>$begin_date,
            "end_date"=>$end_date
        );
        $data = json_encode($data);
        $result = $this->request_post($url,$data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:��ȡ��Ϣ���ͷֲ�������(post)
     * @Param:ͬ��
     * @Return:ͬ��
     * @Description:���ʱ����(30)
     * @Author:helen zheng
     */
    public function getUpstreamMsgDistWeek($access_token,$begin_date,$end_date){
        $url = 'https://api.weixin.qq.com/datacube/getupstreammsgdistweek?access_token='.$access_token;
        $data = array(
            "begin_date"=>$begin_date,
            "end_date"=>$end_date
        );
        $data = json_encode($data);
        $result = $this->request_post($url,$data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:��ȡ��Ϣ���ͷֲ�������(post)
     * @Param:ͬ��
     * @Return:ͬ��
     * @Description:���ʱ����(30)
     * @Author:helen zheng
     */
    public function getUpstreamMsgDistMonth($access_token,$begin_date,$end_date){
        $url = 'https://api.weixin.qq.com/datacube/getupstreammsgdistmonth?access_token='.$access_token;
        $data = array(
            "begin_date"=>$begin_date,
            "end_date"=>$end_date
        );
        $data = json_encode($data);
        $result = $this->request_post($url,$data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:��ȡ�ӿڷ�������(post)
     * @Param:  access_token 	�� 	���ýӿ�ƾ֤
                begin_date 	    �� 	��ȡ���ݵ���ʼ���ڣ�begin_date��end_date�Ĳ�ֵ��С�ڡ����ʱ���ȡ����������ʱ����Ϊ1ʱ��begin_date��end_date�Ĳ�ֵֻ��Ϊ0������С��1��������ᱨ��
                end_date 	    �� 	��ȡ���ݵĽ������ڣ�end_date�������õ����ֵΪ����
     * @Return: ref_date 	    ���ݵ�����
                ref_hour 	    ���ݵ�Сʱ
                callback_count 	ͨ�����������õ�ַ�����Ϣ�󣬱����ظ��û���Ϣ�Ĵ���
                fail_count 	    ����������ʧ�ܴ���
                total_time_cost �ܺ�ʱ������callback_count��Ϊƽ����ʱ
                max_time_cost 	����ʱ
     * @Description:���ʱ����(30)
     * @Author:helen zheng
     */
    public function getInterfaceSummary($access_token,$begin_date,$end_date){
        $url = 'https://api.weixin.qq.com/datacube/getinterfacesummary?access_token='.$access_token;
        $data = array(
            "begin_date"=>$begin_date,
            "end_date"=>$end_date
        );
        $data = json_encode($data);
        $result = $this->request_post($url,$data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:��ȡ�ӿڷ�����ʱ����(post)
     * @Param:
     * @Return:
     * @Description:���ʱ����(1)
     * @Author:helen zheng
     */
    public function getInterfaceSummaryHour($access_token,$begin_date,$end_date){
        $url = 'https://api.weixin.qq.com/datacube/getinterfacesummaryhour?access_token='.$access_token;
        $data = array(
            "begin_date"=>$begin_date,
            "end_date"=>$end_date
        );
        $data = json_encode($data);
        $result = $this->request_post($url,$data);
        $res = $this->resultProcess($result);
        if($res==$result){  /*�ӿڷ���ֵ*/
            return($result);
        }else{  /*�ӿڵ��ô�����Ϣ*/
            return($res);
        }
    }

    /**
     * @FunctionDescription:�ӿڵ��ý�����������жϽӿڵ��óɹ���񲢴���
     * @Param:�ӿڵ��÷���ֵ��json��
     * @Return:����������Ϣ��json��string��
     * @Description:����ӿڵ��óɹ����򱾺�����������ֵ������ӿڵ���ʧ�ܣ����ش�����Ϣ��
     * @Author:helen zheng
     */
    function resultProcess($res){
        if(!empty($res->errcode)){
            return ($this->errorMsg($res->errcode));
        }else{
            return $res;
        }
    }

    /**
     * @FunctionDescription:΢��ȫ�ַ���������˵��
     * @Param:΢�ŷ�����
     * @Return:΢�ŷ������Ӧ������˵��
     * @Description:
     * @Author:helen zheng
     */
    function errorMsg($errcode) {
        switch ($errcode) {
            case -1    : return 'ϵͳ��æ�����Ժ����ԡ�';
            case 0     : return '����ɹ���';
            case 40001 : return '��ȡaccess_tokenʱAppSecret���󣬻���access_token��Ч��';
            case 40002 : return '���Ϸ���ƾ֤���͡�';
            case 40003 : return '���Ϸ���OpenID���뿪����ȷ��OpenID�����û����Ƿ��ѹ�ע���ںţ����Ƿ����������ںŵ�OpenID��';
            case 40004 : return '���Ϸ���ý���ļ�����';
            case 40005 : return '���Ϸ����ļ�����';
            case 40006 : return '���Ϸ����ļ���С';
            case 40007 : return '���Ϸ���ý���ļ�id ';
            case 40008 : return '���Ϸ�����Ϣ���� ';
            case 40009 : return '���Ϸ���ͼƬ�ļ���С';
            case 40010 : return '���Ϸ��������ļ���С';
            case 40011 : return '���Ϸ�����Ƶ�ļ���С';
            case 40012 : return '���Ϸ�������ͼ�ļ���С';
            case 40013 : return '���Ϸ���APPID';
            case 40014 : return '���Ϸ���access_token ';
            case 40015 : return '���Ϸ��Ĳ˵����� ';
            case 40016 : return '���Ϸ��İ�ť���� ';
            case 40017 : return '���Ϸ��İ�ť����';
            case 40018 : return '���Ϸ��İ�ť���ֳ���';
            case 40019 : return '���Ϸ��İ�ťKEY���� ';
            case 40020 : return '���Ϸ��İ�ťURL���� ';
            case 40021 : return '���Ϸ��Ĳ˵��汾��';
            case 40022 : return '���Ϸ����Ӳ˵�����';
            case 40023 : return '���Ϸ����Ӳ˵���ť����';
            case 40024 : return '���Ϸ����Ӳ˵���ť����';
            case 40025 : return '���Ϸ����Ӳ˵���ť���ֳ���';
            case 40026 : return '���Ϸ����Ӳ˵���ťKEY���� ';
            case 40027 : return '���Ϸ����Ӳ˵���ťURL���� ';
            case 40028 : return '���Ϸ����Զ���˵�ʹ���û�';
            case 40029 : return '���Ϸ���oauth_code';
            case 40030 : return '���Ϸ���refresh_token';
            case 40031 : return '���Ϸ���openid�б� ';
            case 40032 : return '���Ϸ���openid�б��� ';
            case 40033 : return '���Ϸ��������ַ������ܰ���\uxxxx��ʽ���ַ� ';
            case 40035 : return '���Ϸ��Ĳ���';
            case 40038 : return '���Ϸ��������ʽ';
            case 40039 : return '���Ϸ���URL���� ';
            case 40050 : return '���Ϸ��ķ���id';
            case 40051 : return '�������ֲ��Ϸ�';
            case 41001 : return 'ȱ��access_token����';
            case 41002 : return 'ȱ��appid����';
            case 41003 : return 'ȱ��refresh_token����';
            case 41004 : return 'ȱ��secret����';
            case 41005 : return 'ȱ�ٶ�ý���ļ�����';
            case 41006 : return 'ȱ��media_id����';
            case 41007 : return 'ȱ���Ӳ˵�����';
            case 41008 : return 'ȱ��oauth code';
            case 41009 : return 'ȱ��openid';
            case 42001 : return 'access_token��ʱ';
            case 42002 : return 'refresh_token��ʱ';
            case 42003 : return 'oauth_code��ʱ';
            case 43001 : return '��ҪGET����';
            case 43002 : return '��ҪPOST����';
            case 43003 : return '��ҪHTTPS����';
            case 43004 : return '��Ҫ�����߹�ע';
            case 43005 : return '��Ҫ���ѹ�ϵ';
            case 44001 : return '��ý���ļ�Ϊ��';
            case 44002 : return 'POST�����ݰ�Ϊ��';
            case 44003 : return 'ͼ����Ϣ����Ϊ��';
            case 44004 : return '�ı���Ϣ����Ϊ��';
            case 45001 : return '��ý���ļ���С��������';
            case 45002 : return '��Ϣ���ݳ�������';
            case 45003 : return '�����ֶγ�������';
            case 45004 : return '�����ֶγ�������';
            case 45005 : return '�����ֶγ�������';
            case 45006 : return 'ͼƬ�����ֶγ�������';
            case 45007 : return '��������ʱ�䳬������';
            case 45008 : return 'ͼ����Ϣ��������';
            case 45009 : return '�ӿڵ��ó�������';
            case 45010 : return '�����˵�������������';
            case 45015 : return '�ظ�ʱ�䳬������';
            case 45016 : return 'ϵͳ���飬�������޸�';
            case 45017 : return '�������ֹ���';
            case 45018 : return '����������������';
            case 46001 : return '������ý������';
            case 46002 : return '�����ڵĲ˵��汾';
            case 46003 : return '�����ڵĲ˵�����';
            case 46004 : return '�����ڵ��û�';
            case 47001 : return '����JSON/XML���ݴ���';
            case 48001 : return 'api����δ��Ȩ';
            case 50001 : return '�û�δ��Ȩ��api';
            default    : return 'δ֪����';
        }
    }

    /**
     * @FunctionDescription:�ӿڵ��õ�get����
     * @Param:�����url��ַ
     * @Return:��json��
     * @Description:����cURL����get���󣬻�ȡ����
     * @Author:helen zheng
     */
    /*�ӿڵ��õ�get����*/
    function request_get($url){
        //��ʼ��cURL����
        $ch = curl_init();
        //����cURL����
        $opts = array(
            //�ھ������ڷ���httpsվ��ʱ��Ҫ������������ر�ssl��֤��
            //��������ʽ����ʱ��Ҫ���ģ���������֤��֤��
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL            => $url,
        );
        curl_setopt_array($ch,$opts);
        //ִ��cURL����
        $output = curl_exec($ch);
        if(curl_errno($ch)){    //cURL�������������
            var_dump(curl_error($ch));
            die;
        }
        //�ر�cURL
        curl_close($ch);
        $res = json_decode($output);
        return($res);    //����json����
    }

    /**
     * @FunctionDescription:�ӿڵ��õ�post����
     * @Param:�����url��ַ��post���ݣ�json��ʽ��
     * @Return:��json��
     * @Description:����cURL����get���󣬻�ȡ����
     * @Author:helen zheng
     */
    function request_post($url,$data){
        //��ʼ��cURL����
        $ch = curl_init();
        //����cURL����
        $opts = array(
            //�ھ������ڷ���httpsվ��ʱ��Ҫ������������ر�ssl��֤��
            //��������ʽ����ʱ��Ҫ���ģ���������֤��֤��
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL            => $url,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $data
        );
        curl_setopt_array($ch,$opts);
        //ִ��cURL����
        $output = curl_exec($ch);
        if(curl_errno($ch)){    //cURL��������������
            var_dump(curl_error($ch));
            die;
        }
        //�ر�cURL
        curl_close($ch);
        $res = json_decode($output);
        return($res);   //����json����
    }

    /**
     * @FunctionDescription:���ض�ý���ļ�����
     * @Param:url
     * @Return:��ý����Ϣ array
     * @Description:
     * @Author:helen zheng
     */
    function downloadFile($url){
        //��ʼ��cURL����
        $ch = curl_init();
        //����cURL����
        $opts = array(
            //�ھ������ڷ���httpsվ��ʱ��Ҫ������������ر�ssl��֤��
            //��������ʽ����ʱ��Ҫ���ģ���������֤��֤��
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL            => $url,
            CURLOPT_HEADER         => 0,
            CURLOPT_NOBODY         => 0
        );
        curl_setopt_array($ch,$opts);
        //ִ��cURL����
        $output = curl_exec($ch);
        $httpinfo = curl_getinfo($ch);
        if(curl_errno($ch)){
            var_dump(curl_error($ch));
        }
        //�ر�cURL
        curl_close($ch);
        return array_merge(array('body'=>$output),array('header'=>$httpinfo));
    }

}