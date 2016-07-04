<?php
namespace  MyMVC;

/**
 *视图类 
 */
class  View
{
    /**
     *模板变量 
     */
    protected  $tVar = array();
    
    /**
     *模板主题 
     */
    protected $theme = null;
    
    /**
     * 模板变量赋值
     */
    public function assgin($name , $value)
    {
        if (is_array($value))
        {
            $this->tVar = array_merge($this->tVar , $value);
        }
        else 
        {
            $this->tVar[$name] = $value;
        }
    }
    
    /**
     *取得变量值 
     */
    public function getValue($name = null)
    {
        if (empty($name) || empty($this->tVar[$name]))
        {
            return $this->tVar;
        }
        else
        {            
            return $this->tVar[$name];
        }
    }
    
    /**
     *输出模板内容 
     *@param string $tempateFile 模板文件名称
     *@param string $charset     字符编码
     *@param string $contentType 输出类型
     *@param string $suffix      缓存前缀
     *@return html
     */
    public function display($tempateFile = null , $charset = 'UTF-8' , $contentType = 'text/html' , $suffix = null)
    {
        //获取系统运行状态
        getMemory('view_start_time');
        //监听视图开始标签
        Hook::listenTag('view_begin' , $tempateFile);
        //解析模板内容
        
        //输出内容
        
        // 监听结束
    }
    
    /**
     * 获取当前模板主题
     * @return string 主题名称
     */
    private function getThemeName()
    {
        if (!empty($this->theme)){
           $theme = $this->theme; 
        } else {
           //是否开启自动侦测模板主题
           if (getConfig('DEFAULT_THEME')){
               //默认模板主题 接收变量
               $t = getConfig('VAR_TEMPLATE');
               if (isset($_GET[$t])){
                   $theme = $_GET[$t];
               }elseif ($mymvc_default_theme = cookie('mymvc_default_theme')){
                   $theme = $mymvc_default_theme;
               }
               if (!in_array($theme, explode(',', getConfig('THEME_LIST')) )){
                   $theme = getConfig('DEFAULT_THEME');
               }
               cookie('mymvc_default_theme' , $theme , 86400);
           }
        }
        defined('APP_THEME') or define('APP_THEME', $theme);
        
        return $theme ? $theme.'/': '';
    }
}