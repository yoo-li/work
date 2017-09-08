<?php
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version 1.1.2
 * ("License"); You may not use this file except in compliance with the 
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an  "AS IS"  basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 * The Original Code is:  SugarCRM Open Source
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
 ********************************************************************************/
/*********************************************************************************
 * $Header: /advent/projects/wesat/vtiger_crm/sugarcrm/modules/Contacts/index.php,v 1.5 2005/03/25 13:37:45 samk Exp $
 * Description:  TODO: To be written.
 ********************************************************************************/








$Config_approvalflows = array (
			array(
			'approvalflows_no' => 'APPROVALFLOW1',
			'approvalflowsstatus' => '1',
			'createnew' => '0',
			'deleted' => '0',
			'description' => '系统创建',
			'flowdata' => '<WorkFlow>
			  <Route ID="11" Name="" FromElementID="1" ToElementID="2"/>
			  <BeginNode ID="1" Name="" x="100" y="50" Radio="20"/>
			  <WorkNode ID="2" Name="直接上级" NodeType="000000" x="200" y="35" Width="80" Height="30"/>
			</WorkFlow>',
			'tabid' => '26',
			'approvalflowstype' => 'SYSTEM',
			),
			array(
			'approvalflows_no' => 'APPROVALFLOW2',
			'approvalflowsstatus' => '1',
			'createnew' => '0',
			'deleted' => '0',
			'description' => '系统创建',
			'flowdata' => '<WorkFlow>
			  <Route ID="11" Name="" FromElementID="1" ToElementID="2"/>
			  <BeginNode ID="1" Name="" x="100" y="50" Radio="20"/>
			  <WorkNode ID="2" Name="直接上级" NodeType="000000" x="200" y="35" Width="80" Height="30"/>
			</WorkFlow>',
			'tabid' => '110',
			'approvalflowstype' => 'SYSTEM',
			),
			array(
			'approvalflows_no' => 'APPROVALFLOW3',
			'approvalflowsstatus' => '1',
			'deleted' => '0',
			'description' => '系统创建',
			'flowdata' => '<WorkFlow>
			  <Route ID="11" Name="" FromElementID="1" ToElementID="2"/>
			  <BeginNode ID="1" Name="" x="100" y="50" Radio="20"/>
			  <WorkNode ID="2" Name="直接上级" NodeType="000000" x="200" y="35" Width="80" Height="30"/>
			</WorkFlow>',
			'tabid' => '20',
			'approvalflowstype' => 'SYSTEM',
			),
			array(
			'approvalflows_no' => 'APPROVALFLOW4',
			'approvalflowsstatus' => '1',
			'deleted' => '0',
			'description' => '系统创建',
			'flowdata' => '<WorkFlow>
			  <Route ID="11" Name="" FromElementID="1" ToElementID="2"/>
			  <BeginNode ID="1" Name="" x="100" y="50" Radio="20"/>
			  <WorkNode ID="2" Name="直接上级" NodeType="000000" x="200" y="35" Width="80" Height="30"/>
			</WorkFlow>',
			'tabid' => '21',
			'approvalflowstype' => 'SYSTEM',
			),
			array(
			'approvalflows_no' => 'APPROVALFLOW5',
			'approvalflowsstatus' => '1',
			'deleted' => '0',
			'description' => '系统创建',
			'flowdata' => '<WorkFlow>
			  <Route ID="11" Name="" FromElementID="1" ToElementID="2"/>
			  <BeginNode ID="1" Name="" x="100" y="50" Radio="20"/>
			  <WorkNode ID="2" Name="直接上级" NodeType="000000" x="200" y="35" Width="80" Height="30"/>
			</WorkFlow>',
			'tabid' => '22',
			'approvalflowstype' => 'SYSTEM',
			),
			array(
			'approvalflows_no' => 'APPROVALFLOW6',
			'approvalflowsstatus' => '1',
			'deleted' => '0',
			'description' => '系统创建',
			'flowdata' => '<WorkFlow>
			  <Route ID="11" Name="" FromElementID="1" ToElementID="2"/>
			  <BeginNode ID="1" Name="" x="100" y="50" Radio="20"/>
			  <WorkNode ID="2" Name="直接上级" NodeType="000000" x="200" y="35" Width="80" Height="30"/>
			</WorkFlow>',
			'tabid' => '122',
			'approvalflowstype' => 'SYSTEM',
			),
			array(
			'approvalflows_no' => 'APPROVALFLOW7',
			'approvalflowsstatus' => '1',
			'deleted' => '0',
			'description' => '系统创建',
			'flowdata' => '<WorkFlow>
			  <Route ID="11" Name="" FromElementID="1" ToElementID="2"/>
			  <BeginNode ID="1" Name="" x="100" y="50" Radio="20"/>
			  <WorkNode ID="2" Name="直接上级" NodeType="000000" x="200" y="35" Width="80" Height="30"/>
			</WorkFlow>',
			'tabid' => '126',
			'approvalflowstype' => 'SYSTEM',
			),
			array(
			'approvalflows_no' => 'APPROVALFLOW8',
			'approvalflowsstatus' => '1',
			'deleted' => '0',
			'description' => '系统创建',
			'flowdata' => '<WorkFlow>
			  <Route ID="11" Name="" FromElementID="1" ToElementID="2"/>
			  <BeginNode ID="1" Name="" x="100" y="50" Radio="20"/>
			  <WorkNode ID="2" Name="直接上级" NodeType="000000" x="200" y="35" Width="80" Height="30"/>
			</WorkFlow>',
			'tabid' => '123',
			'approvalflowstype' => 'SYSTEM',
			),
			array(
			'approvalflows_no' => 'APPROVALFLOW9',
			'approvalflowsstatus' => '1',
			'deleted' => '0',
			'description' => '系统创建',
			'flowdata' => '<WorkFlow>
			  <Route ID="11" Name="" FromElementID="1" ToElementID="2"/>
			  <BeginNode ID="1" Name="" x="100" y="50" Radio="20"/>
			  <WorkNode ID="2" Name="直接上级" NodeType="000000" x="200" y="35" Width="80" Height="30"/>
			</WorkFlow>',
			'tabid' => '127',
			'approvalflowstype' => 'SYSTEM',
			),

);

re_approvalflows($Config_approvalflows);

echo "初始化数据";
exit();



function re_approvalflows($Config_entitynames) {	
	try {
		$TableName = 'approvalflows';

		$entitynames = XN_Query::create ( 'Content' )
						->filter ( 'type', 'eic', $TableName )
						->execute ();
		if (count ( $entitynames ) > 0) {					
			foreach ( $entitynames as $entityname_delete_info ) {
				XN_Content::delete($entityname_delete_info,$TableName);
			}
		}

		foreach ($Config_entitynames as $entityname_info){				
				
				$newcontent = XN_Content::create($TableName,'',false);
				foreach ($entityname_info as $k => $v){
					$newcontent->my->$k = $v;
				}
				$newcontent->save('approvalflows');
				echo "创建(".$TableName.")!<br>";
			}	

	} catch ( XN_Exception $e ) {
		echo $e->getMessage () . "<br>";
		return null;
	}
}





?>
