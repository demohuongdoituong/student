using UnityEngine;
using System.Collections;

public class NewBehaviourScript : MonoBehaviour {

	void OnCollisionEnter2D(Collision2D target){
		if (target.gameObject.name == "seas") {
			Destroy(gameObject);
		}
	}
	
	}
	
