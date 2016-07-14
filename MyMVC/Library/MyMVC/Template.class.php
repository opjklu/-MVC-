<?php
namespace MyMVC;
/**
 *模板解析类
 *@author 王强
 */
class Template
{
    /**
     *标签库数组
     *@var array
     */
    protected   $tagLib = array(); 
    
    /**
     *当前模板文件
     *@var string 
     */
    protected  $thisTemplateFile = '';
    
    /**
     * 筛选 literal
     * @var array
     */
    protected $literal = array();
    
    /**
     * 配置 config
     * @var array
     */
    protected $config  = array();
    
    /**
     * block 标签
     */
    protected  $block  = array();
    
    /**
     *模板变量 
     */
    protected $tVar   = array();
    
    /**
     *架构函数 
     */
    public function __construct()
    {
        $this->config['cachePath']         =   getConfig('CACHE_PATH');
        $this->config['templateSuffix']    =   getConfig('TMPL_TEMPLATE_SUFFIX');
        $this->config['cacheSuffix']       =   getConfig('TMPL_CACHFILE_SUFFIX');
        $this->config['tmplCache']         =   getConfig('TMPL_CACHE_ON');
        $this->config['cacheTime']         =   getConfig('TMPL_CACHE_TIME');
        $this->config['taglibBegin']       =   $this->stripPreg(getConfig('TAGLIB_BEGIN'));
        $this->config['taglibEnd']         =   $this->stripPreg(getConfig('TAGLIB_END'));
        $this->config['tmplBegin']         =   $this->stripPreg(getConfig('TMPL_L_DELIM'));
        $this->config['tmplEnd']           =   $this->stripPreg(getConfig('TMPL_R_DELIM'));
        $this->config['defaultTmpl']       =   getConfig('TEMPLATE_NAME');
        $this->config['layoutItem']        =   getConfig('TMPL_LAYOUT_ITEM');
    }
    
    /**
     *转义模板运算标签
     *@access private
     *@author 王强 
     */
    private function stripPreg($str) 
    {
        return str_replace(
            array('{','}','(',')','|','[',']','-','+','*','.','^','?'),
            array('\{','\}','\(','\)','\|','\[','\]','\-','\+','\*','\.','\^','\?'),
            $str);        
    }
    
    /**
     *设置模板变量 
     */
    public function __set($name, $value)
    {
        
        $this->tVar[$name] = $value;
    }
    /**
     *获取模板变量 
     */
    public function __get($name)
    {
        return isset($this->tVar[$name]) ? null : $this->tVar[$name];
    }
}