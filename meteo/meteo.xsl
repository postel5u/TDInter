<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">

  <xsl:strip-space elements="previsions"/>
    <xsl:output
      method = "html"
      encoding = "UTF-8"
      indent = "yes"
       />
       <xsl:template match="/previsions">
         <div>
               <xsl:apply-templates select="echeance[position() &lt; 5]"/>
             </div>

             <div id="mapid"></div>


       </xsl:template>
       <xsl:template match="echeance[position() &lt; 5]">
           <div>
             <h3>
               Le <xsl:value-of select="substring(@timestamp, 9,2)"/>/<xsl:value-of select="substring(@timestamp, 6,2)"/>/<xsl:value-of select="substring(@timestamp, 1,4)"/> à <xsl:value-of select="substring(@timestamp, 12,2)"/>h
             </h3>
             <xsl:apply-templates select="temperature/level[@val = 'sol']"/>
             <xsl:apply-templates select="pluie"/>
           </div>
       </xsl:template>

       <xsl:template match="temperature/level[@val = 'sol']">
           <p>
             Température : <xsl:value-of select="round((. -273.15))"/>°C
           </p>
       </xsl:template>

       <xsl:template match="pluie">
         <xsl:choose>
           <xsl:when test=". &lt; 2">
             <p>Pas de pluie</p>
           </xsl:when>
           <xsl:when test=". &gt; 2 and . &lt; 8">
             <p>Faible pluie</p>
           </xsl:when>
           <xsl:when test=". &gt; 8 and . &lt; 30">
             <p>Pluie</p>
           </xsl:when>
           <xsl:when test=". &gt; 30 and . &lt; 60">
             <p>Forte pluie</p>
           </xsl:when>
           <xsl:otherwise>
             <p>Orage</p>
           </xsl:otherwise>
         </xsl:choose>

       </xsl:template>



</xsl:stylesheet>
